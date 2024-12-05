<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    //user create account api

    public function userCreateAccount(Request $request){
        try {
            // Extract the 'payload' field from the request
            $payload = $request->input('payload');
           
    
            // Define the API endpoint and headers
            $url = 'https://consolev1.pinbot.ai/api/create-user-account';
            $headers = [
                'Content-Type: application/json',
                'apikey: 68bd0be4-c0fd-11ee-b22d-92672d2d0c2d',
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
                throw new \Exception(curl_error($curl));
            }
    
            curl_close($curl);
    
            // Decode the response
            $responseData = json_decode($response, true);
        
            // Handle the API response
            if ($httpCode >= 200 && $httpCode < 300) {
                return response()->json([
                    'code' => $httpCode,
                    'status' => $responseData['status'] ?? 'Success',
                    'message' => $responseData['message'] ?? 'Operation completed successfully.',
                    'data' => $responseData['data'] ?? null,
                ]);
            }
    
            // Handle API errors
            return response()->json([
                'code' => $httpCode,
                'status' => 'Error',
                'message' => $responseData['message'] ?? 'An error occurred.',
            ], $httpCode);
    
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json([
                'code' => 500,
                'status' => 'Error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function getUserDetails(Request $request){
        $apiKey = $request->input('apikey'); // Replace with your actual API key
        $url = 'https://partnersv1.pinbot.ai/v3/getuserdetails'; // API URL

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
            CURLOPT_CUSTOMREQUEST => 'GET',  // GET request (no payload needed)
            CURLOPT_HTTPHEADER => [
                'apikey: ' . $apiKey,  // Include API key in the header
            ],
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

    public function fetchWeba(Request $request, $wabaid){
        $apiKey = $request->input('apikey'); // Replace with your actual API key
        $url = 'https://partnersv1.pinbot.ai/v3/' . $wabaid; // API URL

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
            CURLOPT_CUSTOMREQUEST => 'GET',  // GET request (no payload needed)
            CURLOPT_HTTPHEADER => [
                'apikey: ' . $apiKey,  // Include API key in the header
            ],
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



    public function sendTemplate(Request $request, $wabaid)
    {
         // Get API endpoint URL dynamically
        $url = "https://partnersv1.pinbot.ai/v3/{$wabaid}/message_templates";

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



    public function carouselTemplate(Request $request, $wabaid)
    {
         // Get API endpoint URL dynamically
        $url = "https://partnersv1.pinbot.ai/v3/{$wabaid}/message_templates";

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


    public function imageTemplate(Request $request, $wabaid)
    {
          // Get API endpoint URL dynamically
          $url = "https://partnersv1.pinbot.ai/v3/{$wabaid}/message_templates";


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
          "apikey: {$apikey}"
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


      public function createTemplateVideo(Request $request, $wabaid) {
        // Get API endpoint URL dynamically
        $url = "https://partnersv1.pinbot.ai/v3/{$wabaid}/message_templates";


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
    


      public function createTemplateDocument(Request $request, $wabaid) {
        // Get API endpoint URL dynamically
        $url = "https://partnersv1.pinbot.ai/v3/{$wabaid}/message_templates";


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



    //  initiate upload

    public function uploadFile(Request $request)
    {
       

      // Get the uploaded file
    $file = $request->file('file');

    // Open the file as binary
    $fileContent = fopen($file->getRealPath(), 'r');

    // Get the API key from the request input
    $apikey = $request->input('apikey');
    $session=$request->input('session');

    // API URL
    $url = "https://partnersv1.pinbot.ai/v3/upload:" .$session;
    //dd($url);

    // Send the API request with binary file data and dynamic API key
    $response = Http::withHeaders([
        'apikey' => $apikey, // Dynamic API key from the request
    ])->withBody(stream_get_contents($fileContent), $file->getMimeType())
        ->post($url);

    // Close the file resource
    fclose($fileContent);

    // Check response status and return
    if ($response->successful()) {
        return response()->json([
            'message' => 'File uploaded successfully!',
            'response' => $response->json(),
        ]);
    } else {
        return response()->json([
            'message' => 'Failed to upload file.',
            'response' => $response->json(),
        ], $response->status());
    }
}
    
    
    }



