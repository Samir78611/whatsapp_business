<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Google\Service\Sheets;
use Firebase\JWT\JWT;

class CalendarController extends Controller
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

    public function getAccessToken()
    {
        // dd("hii");
        $client = new Client();
        $client->setClientId('YOUR_CLIENT_ID');
        $client->setClientSecret('YOUR_CLIENT_SECRET');
        $client->setRedirectUri('YOUR_REDIRECT_URI');
        $client->addScope('https://www.googleapis.com/auth/spreadsheets');
        $client->setAccessType('offline'); // For refresh tokens

        if (!isset($_GET['code'])) {
            // Redirect to Google's OAuth 2.0 server
            $authUrl = $client->createAuthUrl();
            return redirect($authUrl);
        } else {
            // Exchange authorization code for access token
            $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $accessToken = $client->getAccessToken();
            dd($accessToken); // Save or use this token
        }
    }

    //Calender apis 
    public function createCalendar(Request $request)
    {
        // Fetch input parameters from the request
        $accessToken = $request->input('access_token'); // OAuth access token
        $summary = $request->input('summary');
        $description = $request->input('description');
        $location = $request->input('location');
        $timeZone = $request->input('timeZone');

        // Prepare the body data for the calendar creation
        $body = [
            'summary' => $summary,
            'description' => $description,
            'location' => $location,
            'timeZone' => $timeZone,
        ];

        // Google Calendar API URL for creating a new calendar (no API key)
        $url = 'https://www.googleapis.com/calendar/v3/calendars';

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
                'message' => 'An error occurred while creating the calendar.',
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
                'message' => 'Calendar created successfully!',
                'calendar' => $responseData
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to create calendar.',
                'error' => $responseData['error'] ?? 'Unknown error.'
            ], $httpCode);
        }
    }

    public function getCalendar(Request $request)
    {
        // Validate incoming request (ensure access token and calendar ID are passed)
        $validatedData = $request->validate([
            'access_token' => 'required|string',
            'calendar_id' => 'required|string',
        ]);
    
        // Retrieve dynamic values from the request
        $accessToken = $validatedData['access_token'];
        $calendarId = $validatedData['calendar_id'];
    
        // Google Calendar API URL for fetching events
        $url = "https://www.googleapis.com/calendar/v3/calendars/{$calendarId}/events";
    
        // Initialize cURL
        $curl = curl_init();
    
        // Set cURL options
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',  // Use GET for fetching events
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $accessToken, // Use access token for authorization
                'Content-Type: application/json',
            ],
        ]);
    
        // Execute cURL request
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
        // Check for cURL errors
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            return response()->json(['error' => $error], 500);
        }
    
        curl_close($curl);
    
        // Check if the response is valid
        if (empty($response)) {
            return response()->json(['error' => 'Empty response from API'], 500);
        }
    
        // Decode the response (if JSON)
        $responseData = json_decode($response, true);
    
        // If JSON decoding fails, return error
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Failed to decode JSON response', 'details' => json_last_error_msg()], 500);
        }
    
        // Check if the request was successful
        if ($httpCode === 200) {
            return response()->json([
                'message' => 'Calendar events fetched successfully.',
                'data' => $responseData,
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to fetch calendar events.',
                'error' => $responseData['error'] ?? 'Unknown error.',
            ], $httpCode);
        }
    }
    

    public function updateCalendar(Request $request)
    {
        // Validate incoming request (ensure access token, api key, calendar id, and event data are passed)
        $validatedData = $request->validate([
            'access_token' => 'required|string',
            'calendar_id' => 'required|string',
            'summary' => 'required|string', // Assuming you're updating the summary of the calendar
        ]);
    
        // Retrieve dynamic values from the request
        $accessToken = $validatedData['access_token'];
        $calendarId = $validatedData['calendar_id'];
        $summary = $validatedData['summary']; // The new summary of the calendar
    
        // Google Calendar API URL for updating the calendar
        $url = "https://www.googleapis.com/calendar/v3/calendars/{$calendarId}";

        // Initialize cURL
        $curl = curl_init();

        // Set cURL options for the PUT request
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT', // Use PUT to update the calendar
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json',
                'Accept: application/json',
            ],
            CURLOPT_POSTFIELDS => json_encode([
                'summary' => $summary, // Add the new summary data
            ]),
        ]);

        // Execute cURL request
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Check for cURL errors
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            return response()->json(['error' => $error], 500);
        }

        curl_close($curl);

        // Check if the response is valid
        if (empty($response)) {
            return response()->json(['error' => 'Empty response from API'], 500);
        }

        // Decode the response (if JSON)
        $responseData = json_decode($response, true);

        // If JSON decoding fails, return error
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Failed to decode JSON response', 'details' => json_last_error_msg()], 500);
        }

        // Check if the request was successful
        if ($httpCode === 200) {
            return response()->json([
                'message' => 'Calendar updated successfully.',
                'data' => $responseData,
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to update calendar.',
                'error' => $responseData['error'] ?? 'Unknown error.',
            ], $httpCode);
        }
    }

    public function deleteCalendar(Request $request)
    {
        // Validate incoming request (ensure access token and calendar id are passed)
        $validatedData = $request->validate([
            'access_token' => 'required|string',
            'calendar_id' => 'required|string', // The ID of the calendar to delete
        ]);
    
        // Retrieve dynamic parameters from the request
        $accessToken = $validatedData['access_token'];
        $calendarId = $validatedData['calendar_id'];
    
        // Google Calendar API URL for deleting a calendar
        $url = 'https://www.googleapis.com/calendar/v3/calendars/' . urlencode($calendarId);
    
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
        if ($httpCode === 204) {
            return response()->json([
                'message' => 'Calendar deleted successfully!'
            ]);
        } else {
            // Decode the response for error details (if available)
            $responseData = json_decode($response, true);
            return response()->json([
                'message' => 'Failed to delete calendar.',
                'error' => $responseData['error'] ?? 'Unknown error.'
            ], $httpCode);
        }
    }
    
    //shubham credentials testing 
    public function generateJwt()
    {
        // Step 1: Load service account details from the JSON file
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
            //https://www.googleapis.com/auth/calendar
            //https://www.googleapis.com/auth/calendar.readonly
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
