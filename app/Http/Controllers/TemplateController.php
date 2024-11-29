<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function createTemplateLocation(Request $request, $wabaid)
    {
        $apiKey = $request->input('apikey');
        $payload = $request->input('payload');
        $url = 'https://partnersv1.pinbot.ai/v3/' . $wabaid . '/message_templates';  // Correct URL

        // Initialize cURL session
        $curl = curl_init();

        // Set the cURL options
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // Disable SSL host verification
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);  // Disable SSL peer verification
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',  // Change to POST for sending data
            CURLOPT_HTTPHEADER => [
                'apikey: ' . $apiKey,  // Include API key in the header
                'Content-Type: application/json',  // Specify the content type as JSON
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),  // Send the payload as JSON
        ]);

        // Execute the cURL request
        $response = curl_exec($curl);

        // Check for cURL errors
        if ($response === false) {
            return response()->json(['error' => 'cURL error: ' . curl_error($curl)], 500);
        }

        // Get HTTP status code
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Close the cURL session
        curl_close($curl);

        // Check if response is not 200 OK
        if ($httpStatus != 200) {
            return response()->json(['error' => 'API error: ' . $response], $httpStatus);
        }

        // Return the API response as JSON
        return response()->json(json_decode($response), 200);
    }

    public function createTemplateText(Request $request, $wabaid)
    {
        $apiKey = $request->input('apikey');
        $payload = $request->input('payload');
        $url = 'https://partnersv1.pinbot.ai/v3/' . $wabaid . '/message_templates';  // Correct URL

        // Initialize cURL session
        $curl = curl_init();

        // Set the cURL options
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // Disable SSL host verification
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);  // Disable SSL peer verification
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',  // Change to POST for sending data
            CURLOPT_HTTPHEADER => [
                'apikey: ' . $apiKey,  // Include API key in the header
                'Content-Type: application/json',  // Specify the content type as JSON
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),  // Send the payload as JSON
        ]);

        // Execute the cURL request
        $response = curl_exec($curl);

        // Check for cURL errors
        if ($response === false) {
            return response()->json(['error' => 'cURL error: ' . curl_error($curl)], 500);
        }

        // Get HTTP status code
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Close the cURL session
        curl_close($curl);

        // Check if response is not 200 OK
        if ($httpStatus != 200) {
            return response()->json(['error' => 'API error: ' . $response], $httpStatus);
        }

        // Return the API response as JSON
        return response()->json(json_decode($response), 200);
    }

    public function createTemplateCopyCode(Request $request, $wabaid)
    {
        $apiKey = $request->input('apikey');
        $payload = $request->input('payload');
        $url = 'https://partnersv1.pinbot.ai/v3/' . $wabaid . '/message_templates';  // Correct URL

        // Initialize cURL session
        $curl = curl_init();

        // Set the cURL options
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // Disable SSL host verification
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);  // Disable SSL peer verification
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',  // Change to POST for sending data
            CURLOPT_HTTPHEADER => [
                'apikey: ' . $apiKey,  // Include API key in the header
                'Content-Type: application/json',  // Specify the content type as JSON
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),  // Send the payload as JSON
        ]);

        // Execute the cURL request
        $response = curl_exec($curl);

        // Check for cURL errors
        if ($response === false) {
            return response()->json(['error' => 'cURL error: ' . curl_error($curl)], 500);
        }

        // Get HTTP status code
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Close the cURL session
        curl_close($curl);

        // Check if response is not 200 OK
        if ($httpStatus != 200) {
            return response()->json(['error' => 'API error: ' . $response], $httpStatus);
        }

        // Return the API response as JSON
        return response()->json(json_decode($response), 200);
    }

    public function createTemplateCatalog(Request $request, $wabaid)
    {
        $apiKey = $request->input('apikey');
        $payload = $request->input('payload');
        $url = 'https://partnersv1.pinbot.ai/v3/' . $wabaid . '/message_templates';  // Correct URL

        // Initialize cURL session
        $curl = curl_init();

        // Set the cURL options
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // Disable SSL host verification
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);  // Disable SSL peer verification
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',  // Change to POST for sending data
            CURLOPT_HTTPHEADER => [
                'apikey: ' . $apiKey,  // Include API key in the header
                'Content-Type: application/json',  // Specify the content type as JSON
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),  // Send the payload as JSON
        ]);

        // Execute the cURL request
        $response = curl_exec($curl);

        // Check for cURL errors
        if ($response === false) {
            return response()->json(['error' => 'cURL error: ' . curl_error($curl)], 500);
        }

        // Get HTTP status code
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Close the cURL session
        curl_close($curl);

        // Check if response is not 200 OK
        if ($httpStatus != 200) {
            return response()->json(['error' => 'API error: ' . $response], $httpStatus);
        }

        // Return the API response as JSON
        return response()->json(json_decode($response), 200);
    }

    
    public function createTemplateMpm(Request $request, $wabaid)
    {
        $apiKey = $request->input('apikey');
        $payload = $request->input('payload');
        $url = 'https://partnersv1.pinbot.ai/v3/' . $wabaid . '/message_templates';  // Correct URL

        // Initialize cURL session
        $curl = curl_init();

        // Set the cURL options
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // Disable SSL host verification
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);  // Disable SSL peer verification
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',  // Change to POST for sending data
            CURLOPT_HTTPHEADER => [
                'apikey: ' . $apiKey,  // Include API key in the header
                'Content-Type: application/json',  // Specify the content type as JSON
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),  // Send the payload as JSON
        ]);

        // Execute the cURL request
        $response = curl_exec($curl);

        // Check for cURL errors
        if ($response === false) {
            return response()->json(['error' => 'cURL error: ' . curl_error($curl)], 500);
        }

        // Get HTTP status code
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Close the cURL session
        curl_close($curl);

        // Check if response is not 200 OK
        if ($httpStatus != 200) {
            return response()->json(['error' => 'API error: ' . $response], $httpStatus);
        }

        // Return the API response as JSON
        return response()->json(json_decode($response), 200);
    }

}
