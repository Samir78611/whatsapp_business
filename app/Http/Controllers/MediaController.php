<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function getMediaUrl(Request $request, $mediaId)
    {
        $apiKey = $request->input('apikey');
        $phoneNumberId = $request->input('phoneNumberId');

        // Build the API URL
        $url = "https://partnersv1.pinbot.ai/v3/{$mediaId}?phone_number_id={$phoneNumberId}";

        // Initialize cURL session
        $curl = curl_init();

        // Set the cURL options
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // Disable SSL host verification
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // Disable SSL peer verification
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET', // This is a GET request
            CURLOPT_HTTPHEADER => [
                'apikey: ' . $apiKey, // Include API key in the header
                'Content-Type: application/json', // Specify the content type as JSON
            ],
        ]);

        // Execute the cURL request
        $response = curl_exec($curl);

        // Handle cURL errors
        if ($response === false) {
            return response()->json(['error' => 'cURL error: ' . curl_error($curl)], 500);
        }

        // Get HTTP response status
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Handle non-200 HTTP responses
        if ($httpStatus != 200) {
            // Decode the response if it is JSON
            $responseDecoded = json_decode($response, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                // Properly formatted API error response
                return response()->json([
                    'error' => 'API error',
                    'details' => $responseDecoded
                ], $httpStatus);
            } else {
                // If response is not JSON, return it as raw text
                return response()->json([
                    'error' => 'API error',
                    'details' => $response
                ], $httpStatus);
            }
        }

        // Return the successful response as JSON
        return response()->json(json_decode($response, true), 200);
    }

    public function downloadMedia(Request $request)
    {
        // Get the API key and media URL from the request
        $apiKey = $request->input('apikey');
        $mediaUrl = $request->input('mediaurl');

        // Debugging to confirm values
        if (!$mediaUrl || !$apiKey) {
            return response()->json(['error' => 'API key and Media URL are required'], 400);
        }
        // dd($mediaUrl);
        // Initialize cURL session
        $curl = curl_init();

        // Set the cURL options
        curl_setopt_array($curl, [
            CURLOPT_URL => $mediaUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0, // Disable SSL host verification
            CURLOPT_SSL_VERIFYPEER => 0, // Disable SSL peer verification
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'apikey: ' . $apiKey,
            ],
        ]);

        // Execute the cURL request
        $response = curl_exec($curl);

        // Handle cURL errors
        if ($response === false) {
            return response()->json(['error' => 'cURL error: ' . curl_error($curl)], 500);
        }

        // Get HTTP response status
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Check if the response is successful
        if ($httpStatus != 200) {
            return response()->json(['error' => 'Failed to download media', 'status' => $httpStatus], $httpStatus);
        }

        // Extract the filename from the media URL
        $filename = basename(parse_url($mediaUrl, PHP_URL_PATH));

        // Return the downloaded file as a response
        return response($response)
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
