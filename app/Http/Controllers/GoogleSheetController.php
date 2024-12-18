<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\Sheets;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class GoogleSheetController extends Controller
{
    public function fetchSheetData(Request $request)
    {
        // Get dynamic parameters from the request
        $spreadsheetId = $request->input('spreadsheetId');
        $ranges = $request->input('ranges', 'A1:F8'); // Default range is A1:F8
        $apiKey = $request->input('apiKey');

        //if (!$spreadsheetId || !$apiKey) {
        //    return response()->json([
        //        'message' => 'spreadsheetId and apiKey are required parameters.'
        //    ], 400);
        //}

        // Construct the URL dynamically
        $url = "https://sheets.googleapis.com/v4/spreadsheets/$spreadsheetId?includeGridData=true&ranges=$ranges&key=$apiKey";

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
            CURLOPT_CUSTOMREQUEST => 'GET',
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

        // Return the response based on HTTP code
        if ($httpCode === 200) {
            return response()->json([
                'message' => 'Data fetched successfully',
                'data' => json_decode($response, true),
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to fetch data',
                'response' => json_decode($response, true),
            ], $httpCode);
        }
    }




    //getmetaDatabyfilter 
    public function fetchDataByFilter(Request $request)
    {
        // Get dynamic parameters from the request
        $spreadsheetId = $request->input('spreadsheetId');
        $apiKey = $request->input('apiKey');
        $accessToken = $request->input('accessToken'); // Add access token parameter
        $dataFilters = $request->input('dataFilters', [
            ["a1Range" => "Sheet1!A1:F8"]
        ]);
        $includeGridData = $request->input('includeGridData', true);

        // Validate required parameters
        //if (!$spreadsheetId || !$apiKey || !$accessToken) {
        //    return response()->json([
        //        'message' => 'spreadsheetId, apiKey, and accessToken are required parameters.'
        //    ], 400);
        //}

        // Construct the URL dynamically
        $url = "https://sheets.googleapis.com/v4/spreadsheets/$spreadsheetId:getByDataFilter?key=$apiKey";

        // Prepare the payload
        $payload = [
            'dataFilters' => $dataFilters,
            'includeGridData' => $includeGridData
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
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $accessToken, // Add Authorization header
                'Accept: application/json',             // Add Accept header
                'Content-Type: application/json',       // Add Content-Type header
            ],
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

        // Return the response based on HTTP code
        if ($httpCode === 200) {
            return response()->json([
                'message' => 'Data fetched successfully',
                'data' => json_decode($response, true),
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to fetch data',
                'response' => json_decode($response, true),
            ], $httpCode);
        }
    }



    //jwt to generate  token for access for new token

    public function generateJwt()
    {
        // Step 1: Load service account details from the JSON file
        $filePath = storage_path('app/service-account.json'); // Adjust the path to your file location
        $serviceAccountInfo = json_decode(file_get_contents($filePath), true);

        // Step 2: Extract required data from the service account info
        $privateKey = $serviceAccountInfo['private_key'];
        $clientEmail = $serviceAccountInfo['client_email'];
        $tokenUri = $serviceAccountInfo['token_uri'];

        // Step 3: Prepare the JWT payload (claims)
        $currentTime = time();
        $expirationTime = $currentTime + 3600; // Set expiration to 1 hour

        $jwtPayload = [
            'iss' => $clientEmail, // Issuer (the service account email)
            'scope' => 'https://www.googleapis.com/auth/spreadsheets', // Scope you need
            'aud' => $tokenUri, // Audience (token endpoint)
            'exp' => $expirationTime, // Expiration time
            'iat' => $currentTime, // Issued at time
        ];

        // Step 4: Sign the JWT using the service account's private key
        $jwt = JWT::encode($jwtPayload, $privateKey, 'RS256');

        // Step 5: Output the JWT
        return response()->json([
            'jwt' => $jwt,
        ]);
    }

    //demo
    public function fetchSheetDat(Request $request)
    {
        // Get dynamic parameters from the request
        $spreadsheetId = $request->input('spreadsheetId');
        $ranges = $request->input('ranges', 'A1:F8'); // Default range is A1:F8
        $apiKey = $request->input('apiKey');
        $accessToken = $request->input('accessToken'); // Assume access token is passed in the request

        //if (!$spreadsheetId || !$apiKey || !$accessToken) {
        //    return response()->json([
        //        'message' => 'spreadsheetId, apiKey, and accessToken are required parameters.'
        //    ], 400);
        //}

        // Construct the URL dynamically
        $url = "https://sheets.googleapis.com/v4/spreadsheets/$spreadsheetId?includeGridData=true&ranges=$ranges&key=$apiKey";

        // Initialize cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        // Set the headers for the request
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $accessToken", // Adding Bearer token for Authorization
                "Accept: application/json"            // Ensuring response is in JSON format
            ],
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

        // Return the response based on HTTP code
        if ($httpCode === 200) {
            return response()->json([
                'message' => 'Data fetched successfully',
                'data' => json_decode($response, true),
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to fetch data',
                'response' => json_decode($response, true),
            ], $httpCode);
        }
    }

    public function appendData(Request $request)
    {
        // Fetch input parameters from the request
        $spreadsheetId = $request->input('spreadsheet_id');
        $range = $request->input('range');
        $values = $request->input('values'); // Array of values to append
        $accessToken = $request->input('access_token'); // OAuth token

        // Google Sheets API endpoint without API key
        $url = "https://sheets.googleapis.com/v4/spreadsheets/{$spreadsheetId}/values/{$range}:append?valueInputOption=RAW&insertDataOption=INSERT_ROWS";

        // cURL Implementation
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode(['values' => $values]),
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json',
                'Accept: application/json',
            ],
        ]);

        // Execute the request and capture the response
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Close the cURL session
        curl_close($curl);

        // Return response
        if ($httpCode >= 200 && $httpCode < 300) {
            return response()->json([
                'message' => 'Data appended successfully',
                'response' => json_decode($response, true),
            ], $httpCode);
        } else {
            return response()->json([
                'message' => 'Failed to append data',
                'error' => json_decode($response, true),
            ], $httpCode);
        }
    }
}
