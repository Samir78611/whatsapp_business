<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class deleteController extends Controller
{
    //delete template api

    public function deleteMessageTemplate(Request $request)
    {
       // Extract the 'name' and 'wabaid' parameters from the request
       $name = $request->input('name');
       $apiKey=$request->input('apikey');
       $webaid = $request->input('wabaid');

       // If 'name' is not provided, return an error response
       if (!$name || !$webaid) {
           return response()->json(['error' => 'Name and wabaid parameters are required'], 400);
       }

       // Define the API endpoint and correctly interpolate the $wabaid and $name variables
       $url = "https://partnersv1.pinbot.ai/v3/{$webaid}/message_templates?name={$name}";

       // Initialize cURL
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
           CURLOPT_CUSTOMREQUEST => "DELETE",
           CURLOPT_HTTPHEADER => [
               'Cache-Control: no-cache',
               'Postman-Token: <calculated when request is sent>',
               'Host: <calculated when request is sent>',
               'User-Agent: PostmanRuntime/7.32.1',
               'Accept: */*',
               'Accept-Encoding: gzip, deflate, br',
               'Connection: keep-alive',
               'apikey: '.$apiKey,
               'Content-Type: application/json'  // Ensuring content type is set for JSON payload
           ],
       ]);

       // Execute the cURL request and capture the response
       $response = curl_exec($curl);

       // Get the response status code
       $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

       // Close the cURL session
       curl_close($curl);

       // Check if the API request was successful (status code 200)
       if ($httpCode == 200) {
           // Return a success response with the "Delete successfully" message
           return response()->json([
               'message' => 'Delete successfully',
               'data' => json_decode($response)
           ], 200);
       } else {
           // If the request failed, return an error with the response
           return response()->json([
               'error' => 'Failed to delete message template',
               'response' => json_decode($response)
           ], $httpCode);
       }
   }


//   delete template id and name 
public function deleteTemplateById(Request $request)
{
    // Extract the 'hsm_id' and 'name' parameters from the request
    $apiKey=$request->input('apikey');
    $wabaid=$request->input('wabaid');
    $hsmId = $request->input('hsm_id');
    $name = $request->input('name');
    

    // If 'hsm_id' or 'name' are not provided, return an error response
    if (!$hsmId || !$name) {
        return response()->json(['error' => 'Both hsm_id and name parameters are required'], 400);
    }

    // Define the API endpoint and correctly interpolate the variables into the URL
    $url = "https://partnersv1.pinbot.ai/v3/$wabaid/message_templates?hsm_id={$hsmId}&name={$name}";
    //dd($url);

    // Initialize cURL
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
        CURLOPT_CUSTOMREQUEST => "DELETE",
        CURLOPT_HTTPHEADER => [
            'Cache-Control: no-cache',
            'Postman-Token: <calculated when request is sent>',
            'Host: <calculated when request is sent>',
            'User-Agent: PostmanRuntime/7.32.1',
            'Accept: */*',
            'Accept-Encoding: gzip, deflate, br',
            'Connection: keep-alive',
            'apikey: '.$apiKey,
            'Content-Type: application/json'  // Ensuring content type is set for JSON payload
        ],
    ]);

    // Execute the cURL request and capture the response
    $response = curl_exec($curl);

    // Get the response status code
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    // Close the cURL session
    curl_close($curl);

    // Check if the API request was successful (status code 200)
    if ($httpCode == 200) {
        // Return a success response with the "Delete successfully" message
        return response()->json([
            'message' => 'Delete successfully',
            'data' => json_decode($response)
        ], 200);
    } else {
        // If the request failed, return an error with the response
        return response()->json([
            'error' => 'Failed to delete message template',
            'response' => json_decode($response)
        ], $httpCode);
    }
}
}
