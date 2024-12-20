<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Sheets;
use Firebase\JWT\JWT;
class Calenderlistcontroller extends Controller
{
    public function getCalendarListt(Request $request)
    {
        // Load the service account credentials
        $credentialsPath = app_path('Client_credentials.json');

        // Check if the file exists and load it
        if (!file_exists($credentialsPath)) {
            dd("File not found at path: $credentialsPath");
        }

        // Decode the credentials
        $credentials = json_decode(file_get_contents($credentialsPath), true);

        // Output the path or credentials for debugging
        // dd($credentialsPath, $credentials);

        // Get an access token
        $token = $this->getAccessToken($credentials);
        // dd($token);

        if (isset($token['error'])) {
            return response()->json(['error' => $token['error']], 400);
        }

        // Set up the API URL and query parameters
        $url = "https://www.googleapis.com/calendar/v3/users/me/calendarList";
        $queryParams = http_build_query([
            'maxResults' => $request->input('maxResults', 10),
            'minAccessRole' => $request->input('minAccessRole', 'reader'),
            'showDeleted' => $request->input('showDeleted', false),
            'showHidden' => $request->input('showHidden', false),
            'pageToken' => $request->input('pageToken'),
            'syncToken' => $request->input('syncToken'),
        ]);

        // Initialize cURL
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url . '?' . $queryParams,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . $token['access_token'],
            ],
        ]);

        // Execute the cURL request
        $response = curl_exec($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Handle errors
        if ($httpStatus !== 200) {
            return response()->json(['error' => 'Failed to fetch calendar list', 'details' => json_decode($response)], $httpStatus);
        }

        return response()->json(json_decode($response, true));
    }

    private function getAccessToken($credentials)
    {
        $url = "https://oauth2.googleapis.com/token";

        $postData = [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $this->createJwt($credentials),
        ];

        // Initialize cURL
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($postData),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/x-www-form-urlencoded",
            ],
        ]);

        // Execute the cURL request
        $response = curl_exec($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpStatus !== 200) {
            return ['error' => 'Failed to fetch access token', 'details' => json_decode($response)];
        }

        return json_decode($response, true);
    }



    private function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    public function insertCalendarList(Request $request)
    {
        // Fetch input parameters from the request
        $accessToken = $request->input('access_token'); // OAuth access token
        $calendarId = $request->input('id'); // Calendar ID to add
        $colorRgbFormat = $request->input('colorRgbFormat', false); // Optional query parameter

        // Validate required input
        if (!$calendarId) {
            return response()->json([
                'message' => 'The calendar ID (id) is required.',
            ], 400);
        }

        // Google Calendar API URL for adding a calendar to the user's list
        $url = 'https://www.googleapis.com/calendar/v3/users/me/calendarList';
        if ($colorRgbFormat) {
            $url .= '?colorRgbFormat=true';
        }

        // Prepare the body data for the request
        $body = [
            'id' => $calendarId, // Calendar ID is required
        ];

        // Initialize cURL
        $curl = curl_init();

        // Set cURL options for POST request
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $accessToken, // Use access token for authorization
                'Content-Type: application/json',
                'Accept: application/json',
            ],
            CURLOPT_POSTFIELDS => json_encode($body), // Pass the request body as JSON
        ]);

        // Execute cURL request
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Check for cURL errors
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            return response()->json([
                'message' => 'An error occurred while adding the calendar to the list.',
                'error' => $error
            ], 500);
        }

        curl_close($curl);

        // Decode the response (if JSON)
        $responseData = json_decode($response, true);

        // If JSON decoding fails, return error
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json([
                'message' => 'Failed to decode JSON response.',
                'error' => json_last_error_msg()
            ], 500);
        }

        // Check if the request was successful
        if ($httpCode === 200 || $httpCode === 201) {
            return response()->json([
                'message' => 'Calendar added to list successfully!',
                'calendar' => $responseData
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to add calendar to the list.',
                'error' => $responseData['error'] ?? 'Unknown error.'
            ], $httpCode);
        }
    }

    public function getCalendarlist(Request $request)
    {
        // Fetch input parameters from the request
        $accessToken = $request->input('access_token'); // OAuth access token
        $calendarId = $request->input('calendar_id', 'primary'); // Calendar ID (default to "primary" if not provided)

        // Validate required input
        if (!$calendarId) {
            return response()->json([
                'message' => 'The calendar ID (calendar_id) is required.',
            ], 400);
        }

        // Google Calendar API URL for retrieving calendar details
        $url = 'https://www.googleapis.com/calendar/v3/users/me/calendarList/' . urlencode($calendarId);

        // Initialize cURL
        $curl = curl_init();

        // Set cURL options for GET request
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $accessToken, // Use access token for authorization
                'Accept: application/json',
            ],
        ]);

        // Execute cURL request
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Check for cURL errors
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            return response()->json([
                'message' => 'An error occurred while retrieving the calendar details.',
                'error' => $error
            ], 500);
        }

        curl_close($curl);

        // Decode the response (if JSON)
        $responseData = json_decode($response, true);

        // If JSON decoding fails, return error
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json([
                'message' => 'Failed to decode JSON response.',
                'error' => json_last_error_msg()
            ], 500);
        }

        // Check if the request was successful
        if ($httpCode === 200) {
            return response()->json([
                'message' => 'Calendar details retrieved successfully!',
                'calendar' => $responseData
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to retrieve calendar details.',
                'error' => $responseData['error'] ?? 'Unknown error.'
            ], $httpCode);
        }
    }

    public function updateCalendarlist(Request $request)
    {
        // Fetch input parameters from the request
        $accessToken = $request->input('access_token'); // OAuth access token
        $calendarId = $request->input('calendar_id', 'primary'); // Calendar ID (default to "primary" if not provided)
        $summary = $request->input('summary'); // Updated summary
        $description = $request->input('description'); // Updated description
        $location = $request->input('location'); // Updated location
        $timeZone = $request->input('timeZone'); // Updated time zone
        $colorRgbFormat = $request->input('colorRgbFormat', false); // Optional query parameter

        // Validate required input
        if (!$calendarId) {
            return response()->json([
                'message' => 'The calendar ID (calendar_id) is required.',
            ], 400);
        }

        // Google Calendar API URL for updating calendar details
        $url = 'https://www.googleapis.com/calendar/v3/users/me/calendarList/' . urlencode($calendarId);

        // Add optional query parameter
        if ($colorRgbFormat) {
            $url .= '?colorRgbFormat=true';
        }

        // Prepare the body data for the update
        $body = [];
        if ($summary)
            $body['summary'] = $summary;
        if ($description)
            $body['description'] = $description;
        if ($location)
            $body['location'] = $location;
        if ($timeZone)
            $body['timeZone'] = $timeZone;

        // Initialize cURL
        $curl = curl_init();

        // Set cURL options for PUT request
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $accessToken, // Use access token for authorization
                'Content-Type: application/json',
                'Accept: application/json',
            ],
            CURLOPT_POSTFIELDS => json_encode($body), // Pass the request body as JSON
        ]);

        // Execute cURL request
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Check for cURL errors
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            return response()->json([
                'message' => 'An error occurred while updating the calendar details.',
                'error' => $error
            ], 500);
        }

        curl_close($curl);

        // Decode the response (if JSON)
        $responseData = json_decode($response, true);

        // If JSON decoding fails, return error
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json([
                'message' => 'Failed to decode JSON response.',
                'error' => json_last_error_msg()
            ], 500);
        }

        // Check if the request was successful
        if ($httpCode === 200) {
            return response()->json([
                'message' => 'Calendar details updated successfully!',
                'calendar' => $responseData
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to update calendar details.',
                'error' => $responseData['error'] ?? 'Unknown error.'
            ], $httpCode);
        }
    }

    public function deleteCalendarlist(Request $request)
    {
        // Fetch input parameters from the request
        $accessToken = $request->input('access_token'); // OAuth access token
        $calendarId = $request->input('calendar_id', 'primary'); // Calendar ID (default to "primary" if not provided)

        // Validate required input
        if (!$calendarId) {
            return response()->json([
                'message' => 'The calendar ID (calendar_id) is required.',
            ], 400);
        }

        // Google Calendar API URL for deleting a calendar
        $url = 'https://www.googleapis.com/calendar/v3/users/me/calendarList/' . urlencode($calendarId);

        // Initialize cURL
        $curl = curl_init();

        // Set cURL options for DELETE request
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $accessToken, // Use access token for authorization
                'Accept: application/json',
            ],
        ]);

        // Execute cURL request
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Check for cURL errors
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            return response()->json([
                'message' => 'An error occurred while deleting the calendar.',
                'error' => $error
            ], 500);
        }

        curl_close($curl);

        // Check if the request was successful
        if ($httpCode === 204) { // HTTP 204: No Content indicates successful deletion
            return response()->json([
                'message' => 'Calendar deleted successfully!',
            ]);
        } else {
            // Decode response for detailed error information
            $responseData = json_decode($response, true);

            return response()->json([
                'message' => 'Failed to delete calendar.',
                'error' => $responseData['error'] ?? 'Unknown error.',
            ], $httpCode);
        }
    }


    public function generateJwt()
    {
        // Step 1: Load service account details from the JSON file
        // $credentialsPath = app_path('Client_credentials.json');

        $filePath = storage_path('app/credentials.json'); // Adjust the path to your file location
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
            'scope' => 'https://www.googleapis.com/auth/calendar', // Scope you need
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

}

