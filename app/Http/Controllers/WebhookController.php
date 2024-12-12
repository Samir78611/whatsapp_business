<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WebhookController extends Controller
{
    public function setWebhook(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'phone_number_id' => 'required|string',
            'webhook_url' => 'required|url',
            'headers' => 'required|array',
            'headers.header1' => 'required|string',
            'headers.header2' => 'required|string',
            'apikey' => 'required|string',
        ]);
    

        // Extract data from request
        $phoneNumberId = $validatedData['phone_number_id'];
        $webhookUrl = $validatedData['webhook_url'];
        $headers = $validatedData['headers'];
        $apiKey = $validatedData['apikey'];

        // Construct URL
        $url = "https://partnersv1.pinbot.ai/v3/{$phoneNumberId}/setwebhook";

        // Prepare payload
        $payload = [
            'webhook_url' => $webhookUrl,
            'headers' => $headers,
        ];
       

        // Prepare headers
        $curlHeaders = [
            "Content-Type: application/json",
            "apikey: $apiKey",
        ];

        // Initialize cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => $curlHeaders,
        ]);

        // Execute the request
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Check for cURL errors
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);

            return response()->json([
                'message' => 'cURL error occurred',
                'error' => $error,
            ], 500);
        }

        curl_close($curl);

        // Return the response
        return response()->json([
            'http_code' => $httpCode,
            'response' => json_decode($response, true),
        ]);
    }


    public function getWebhook(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'phone_number_id' => 'required|string',
            'apikey' => 'required|string',
            'webhook_url' => 'required|url',
            'headers' => 'required|array',
            'headers.header1' => 'required|string',
            'headers.header2' => 'required|string',
        ]);

      

        // Extract data from request
        $phoneNumberId = $validatedData['phone_number_id'];
        $apiKey = $validatedData['apikey'];
        $webhookUrl = $validatedData['webhook_url'];
        $headers = $validatedData['headers'];

        // Construct URL
        $url = "https://partnersv1.pinbot.ai/v3/{$phoneNumberId}/getwebhook";

        // Prepare headers
        $curlHeaders = [
            "Content-Type: application/json",
            "apikey: $apiKey",
        ];
      

        // Prepare payload for GET (unconventional, if required)
        $queryString = http_build_query([
            'webhook_url' => $webhookUrl,
            'headers' => $headers,
        ]);

        $urlWithQuery = $url . '?' . $queryString;

        // Initialize cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($curl, [
            CURLOPT_URL => $urlWithQuery,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => $curlHeaders,
        ]);

        // Execute the request
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Check for cURL errors
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);

            return response()->json([
                'message' => 'cURL error occurred',
                'error' => $error,
            ], 500);
        }

        curl_close($curl);

        // Return the response
        return response()->json([
            'http_code' => $httpCode,
            'response' => json_decode($response, true),
        ]);
    }
}
