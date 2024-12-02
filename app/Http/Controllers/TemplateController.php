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


    //edit template 02-12-2024

    public function editTemplateMultipleButton(Request $request, $msgtemplateid) {
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



      public function editTempCarousel(Request $request, $msgtemplateid) {
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

    public function editTemplateImage(Request $request, $msgtemplateid) {
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

      public function editTemplateVideo(Request $request, $msgtemplateid) {
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
    
    public function editTemplateDocument(Request $request, $msgtemplateid) {
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
            'Cache-Control: no-cache',
            'Postman-Token: <calculated when request is sent>',
            'Content-Type: application/json',
            'Content-Length: <calculated when request is sent>',
            'Host: <calculated when request is sent>',
            'User-Agent: PostmanRuntime/7.32.1',
            'Accept: */*',
            'Accept-Encoding: gzip, deflate, br',
            'Connection: keep-alive',
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
    
    

}
