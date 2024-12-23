<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        // dd($response);
        if ($response === false) {
            return response()->json(['error' => 'cURL error: ' . curl_error($curl)], 500);
        }

        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

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

        return response()->json(json_decode($response, true), 200);
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
        // dd($response);
        if ($response === false) {
            return response()->json(['error' => 'cURL error: ' . curl_error($curl)], 500);
        }

        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

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

        return response()->json(json_decode($response, true), 200);
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
        // dd($response);
        if ($response === false) {
            return response()->json(['error' => 'cURL error: ' . curl_error($curl)], 500);
        }

        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

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

        return response()->json(json_decode($response, true), 200);
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
        // dd($response);
        if ($response === false) {
            return response()->json(['error' => 'cURL error: ' . curl_error($curl)], 500);
        }

        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

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

        return response()->json(json_decode($response, true), 200);
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
        // dd($response);
        if ($response === false) {
            return response()->json(['error' => 'cURL error: ' . curl_error($curl)], 500);
        }

        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

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

        return response()->json(json_decode($response, true), 200);
    }

    //edit template 02-12-2024

    public function editTemplateMultipleButton(Request $request, $msgtemplateid)
    {
        // Get API endpoint URL dynamically
        $url = "https://partnersv1.pinbot.ai/v3/{$msgtemplateid}";


        // Retrieve the apikey from the request
        $apikey = $request->input('apikey');
        if (!$apikey) {
            return response()->json([
                'message' => 'Missing required apikey in the request',
            ], 400);
        }

        // Retrieve payload from the request body and exclude the apikey
        $payload = $request->except('apikey');

        // Set headers with the apikey
        $headers = [
            'Content-Type: application/json',
            "apikey: {$apikey}",
        ];
        //dd($headers);

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
            CURLOPT_HTTPHEADER => $headers,
        ]);

        // Execute the request and capture the response
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

        // Decode JSON response
        $responseData = json_decode($response, true);

        // Return the response based on HTTP status code
        if ($httpCode >= 200 && $httpCode < 300) {
            return response()->json($responseData, $httpCode);
        } else {
            return response()->json([
                'message' => 'Failed to send API request',
                'error' => $responseData,
            ], $httpCode);
        }
    }

    public function editTempCarousel(Request $request, $msgtemplateid)
    {
        // Get API endpoint URL dynamically
        $url = "https://partnersv1.pinbot.ai/v3/{$msgtemplateid}";


        // Retrieve the apikey from the request
        $apikey = $request->input('apikey');
        if (!$apikey) {
            return response()->json([
                'message' => 'Missing required apikey in the request',
            ], 400);
        }

        // Retrieve payload from the request body and exclude the apikey
        $payload = $request->except('apikey');


        // Set headers with the apikey
        $headers = [
            'Content-Type: application/json',
            "apikey: {$apikey}",
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
            CURLOPT_HTTPHEADER => $headers,
        ]);

        // Execute the request and capture the response
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

        // Decode JSON response
        $responseData = json_decode($response, true);

        // Return the response based on HTTP status code
        if ($httpCode >= 200 && $httpCode < 300) {
            return response()->json($responseData, $httpCode);
        } else {
            return response()->json([
                'message' => 'Failed to send API request',
                'error' => $responseData,
            ], $httpCode);
        }
    }
    //  edit template image

    public function editTemplateImage(Request $request, $msgtemplateid)
    {
        // Get API endpoint URL dynamically
        $url = "https://partnersv1.pinbot.ai/v3/{$msgtemplateid}";

        // Retrieve the apikey from the request
        $apikey = $request->input('apikey');
        if (!$apikey) {
            return response()->json([
                'message' => 'Missing required apikey in the request',
            ], 400);
        }

        // Retrieve payload from the request body and exclude the apikey
        $payload = $request->except('apikey');


        // Set headers with the apikey
        $headers = [
            'Content-Type: application/json',
            "apikey: {$apikey}",
        ];
        //dd($headers);

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
            CURLOPT_HTTPHEADER => $headers,
        ]);

        // Execute the request and capture the response
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

        // Decode JSON response
        $responseData = json_decode($response, true);

        // Return the response based on HTTP status code
        if ($httpCode >= 200 && $httpCode < 300) {
            return response()->json($responseData, $httpCode);
        } else {
            return response()->json([
                'message' => 'Failed to send API request',
                'error' => $responseData,
            ], $httpCode);
        }
    }

    //edit template video

    public function editTemplateVideo(Request $request, $msgtemplateid)
    {
        // Get API endpoint URL dynamically
        $url = "https://partnersv1.pinbot.ai/v3/{$msgtemplateid}";


        // Retrieve the apikey from the request
        $apikey = $request->input('apikey');
        if (!$apikey) {
            return response()->json([
                'message' => 'Missing required apikey in the request',
            ], 400);
        }

        // Retrieve payload from the request body and exclude the apikey
        $payload = $request->except('apikey');


        // Set headers with the apikey
        $headers = [
            'Content-Type: application/json',
            "apikey: {$apikey}",
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
            CURLOPT_HTTPHEADER => $headers,
        ]);

        // Execute the request and capture the response
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

        // Decode JSON response
        $responseData = json_decode($response, true);

        // Return the response based on HTTP status code
        if ($httpCode >= 200 && $httpCode < 300) {
            return response()->json($responseData, $httpCode);
        } else {
            return response()->json([
                'message' => 'Failed to send API request',
                'error' => $responseData,
            ], $httpCode);
        }
    }

    //  edit template document 

    public function editTemplateDocument(Request $request, $msgtemplateid)
    {
        // Get API endpoint URL dynamically
        $url = "https://partnersv1.pinbot.ai/v3/{$msgtemplateid}";


        // Retrieve the apikey from the request
        $apikey = $request->input('apikey');
        if (!$apikey) {
            return response()->json([
                'message' => 'Missing required apikey in the request',
            ], 400);
        }

        // Retrieve payload from the request body and exclude the apikey
        $payload = $request->except('apikey');


        // Set headers with the apikey
        $headers = [
            'Content-Type: application/json',
            "apikey: {$apikey}",
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
            CURLOPT_HTTPHEADER => $headers,
        ]);

        // Execute the request and capture the response
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

        // Decode JSON response
        $responseData = json_decode($response, true);

        // Return the response based on HTTP status code
        if ($httpCode >= 200 && $httpCode < 300) {
            return response()->json($responseData, $httpCode);
        } else {
            return response()->json([
                'message' => 'Failed to send API request',
                'error' => $responseData,
            ], $httpCode);
        }
    }


    public function editTemplateLocation(Request $request, $msgtemplateid)
    {
        $apiKey = $request->input('apikey');
        $payload = $request->input('payload');
        $url = 'https://partnersv1.pinbot.ai/v3/' . $msgtemplateid;  // Correct URL

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
        // dd($response);
        if ($response === false) {
            return response()->json(['error' => 'cURL error: ' . curl_error($curl)], 500);
        }

        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

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

        return response()->json(json_decode($response, true), 200);
    }

    public function editTemplateText(Request $request, $msgtemplateid)
    {
        $apiKey = $request->input('apikey');
        $payload = $request->input('payload');
        $url = 'https://partnersv1.pinbot.ai/v3/' . $msgtemplateid;  // Correct URL

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
        // dd($response);
        if ($response === false) {
            return response()->json(['error' => 'cURL error: ' . curl_error($curl)], 500);
        }

        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

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

        return response()->json(json_decode($response, true), 200);
    }

    public function editTemplateCopyCode(Request $request, $msgtemplateid)
    {
        $apiKey = $request->input('apikey');
        $payload = $request->input('payload');
        $url = 'https://partnersv1.pinbot.ai/v3/' . $msgtemplateid;  // Correct URL

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
        // dd($response);
        if ($response === false) {
            return response()->json(['error' => 'cURL error: ' . curl_error($curl)], 500);
        }

        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

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

        return response()->json(json_decode($response, true), 200);
    }

    public function editTemplateCatalog(Request $request, $msgtemplateid)
    {
        $apiKey = $request->input('apikey');
        $payload = $request->input('payload');
        $url = 'https://partnersv1.pinbot.ai/v3/' . $msgtemplateid;  // Correct URL

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
        // dd($response);
        if ($response === false) {
            return response()->json(['error' => 'cURL error: ' . curl_error($curl)], 500);
        }

        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

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

        return response()->json(json_decode($response, true), 200);
    }

    public function editTemplateMpm(Request $request, $msgtemplateid)
    {
        $apiKey = $request->input('apikey');
        $payload = $request->input('payload');
        $url = 'https://partnersv1.pinbot.ai/v3/' . $msgtemplateid;  // Correct URL

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
        // dd($response);
        if ($response === false) {
            return response()->json(['error' => 'cURL error: ' . curl_error($curl)], 500);
        }

        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

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

        return response()->json(json_decode($response, true), 200);
    }


    //media
    public function uploadMediaFile(Request $request, $phoneNumberId)
    {
        // API endpoint URL
        $url = "https://partnersv1.pinbot.ai/v3/{$phoneNumberId}/media";

        // Retrieve the apikey from the request
        $apikey = $request->input('apikey');
        if (!$apikey) {
            return response()->json([
                'message' => 'Missing required apikey in the request',
            ], 400);
        }

        // Check if the file is present in the request
        if (!$request->hasFile('sheet')) {
            return response()->json([
                'message' => 'Missing required file in the request',
            ], 400);
        }

        // Retrieve the uploaded file
        $file = $request->file('sheet');

        // Prepare the file for upload using CURLFile
        $filePath = $file->getPathname();
        $fileName = $file->getClientOriginalName();
        $fileMimeType = $file->getMimeType();
        $fileData = new \CURLFile($filePath, $fileMimeType, $fileName);

        // Prepare the form data
        $postFields = [
            'sheet' => $fileData,
        ];

        // Set headers with the apikey
        $headers = [
            'Cache-Control: no-cache',
            'Content-Type: multipart/form-data',
            "apikey: {$apikey}",
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
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_HTTPHEADER => $headers,
        ]);

        // Execute the request and capture the response
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

        // Decode JSON response
        $responseData = json_decode($response, true);

        // Return the response based on HTTP status code
        if ($httpCode >= 200 && $httpCode < 300) {
            return response()->json($responseData, $httpCode);
        } else {
            return response()->json([
                'message' => 'Failed to send API request',
                'error' => $responseData,
            ], $httpCode);
        }
    }


    //downlaod media
    public function downloadMedia(Request $request, $mediaId, $phoneNumberId)
    {
        // Retrieve the apikey from the request
        $apikey = $request->input('apikey');
        if (!$apikey) {
            return response()->json([
                'message' => 'Missing required apikey in the request',
            ], 400);
        }

        // Construct the URL with placeholders replaced by actual values
        $url = "https://partnersv1.pinbot.ai/v3/downloadMedia/{$mediaId}?phone_number_id={$phoneNumberId}";

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
            CURLOPT_HTTPHEADER => [
                'apikey: ' . $apikey,
            ],
        ]);

        // Execute the request and capture the response
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);

        // Close the cURL session
        curl_close($curl);

        // Check the response status
        if ($httpCode >= 200 && $httpCode < 300) {
            // Return the response as-is if it's successful (e.g., file content)
            return response()->stream(
                function () use ($response) {
                    echo $response;
                },
                200,
                [
                    'Content-Type' => $contentType,
                    'Content-Disposition' => 'attachment; filename="downloaded_media"',
                ]
            );
        } else {
            return response()->json([
                'message' => 'Failed to download media',
                'error' => $response,
            ], $httpCode);
        }
    }


    //delete media

    public function deleteMedia(Request $request, $mediaId, $phoneNumberId)
    {
        // Retrieve the apikey from the request
        $apikey = $request->input('apikey');
        if (!$apikey) {
            return response()->json([
                'message' => 'Missing required apikey in the request',
            ], 400);
        }

        // Construct the URL with placeholders replaced by actual values
        $url = "https://partnersv1.pinbot.ai/v3/{$mediaId}?phone_number_id={$phoneNumberId}";

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
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => [
                'apikey: ' . $apikey,
                'Content-Type: application/json',
            ],
        ]);

        // Execute the request and capture the response
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Close the cURL session
        curl_close($curl);

        // Check the response status
        if ($httpCode >= 200 && $httpCode < 300) {
            return response()->json([
                'message' => 'Media deleted successfully',
                'response' => json_decode($response, true),
            ], $httpCode);
        } else {
            return response()->json([
                'message' => 'Failed to delete media',
                'error' => json_decode($response, true),
            ], $httpCode);
        }
    }

    //fetch templates - 23/12/2024
    // Get template with pagination
    public function templateWithPagination(Request $request)
    {
        $apiKey = $request->input('apikey'); // API key is required
        $wabaId = $request->input('wabaid'); // WABA ID is required

        $baseUrl = "https://partnersv1.pinbot.ai/v3/$wabaId/message_templates";

        // Fetch all query parameters dynamically, excluding API key and WABA ID
        $queryParams = $request->except(['apikey', 'wabaid']); 

        // Build the API URL with query parameters
        $url = $baseUrl . '?' . http_build_query($queryParams);

        // Initialize cURL session
        $curl = curl_init();

        // Set cURL options
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'apikey: ' . $apiKey,
        ]);

        // Execute cURL request
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
            $responseDecoded = json_decode($response, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                return response()->json([
                    'error' => 'API error',
                    'details' => $responseDecoded
                ], $httpStatus);
            } else {
                return response()->json([
                    'error' => 'API error',
                    'details' => $response
                ], $httpStatus);
            }
        }

        // Return the successful response
        return response()->json(json_decode($response, true), 200);
    }

    public function getAllTemplate(Request $request)
    {
        $apiKey = $request->input('apikey'); // Get the API key dynamically
        $wabaId = $request->input('wabaid'); // Get the WABA ID dynamically

        $baseUrl = "https://partnersv1.pinbot.ai/v3/$wabaId/message_templates";

        // Initialize cURL session
        $curl = curl_init();

        // Set cURL options
        curl_setopt($curl, CURLOPT_URL, $baseUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'apikey: ' . $apiKey,
        ]);

        // Execute cURL request
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
            $responseDecoded = json_decode($response, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                return response()->json([
                    'error' => 'API error',
                    'details' => $responseDecoded
                ], $httpStatus);
            } else {
                return response()->json([
                    'error' => 'API error',
                    'details' => $response
                ], $httpStatus);
            }
        }

        // Return the successful response
        return response()->json(json_decode($response, true), 200);
    }
}
