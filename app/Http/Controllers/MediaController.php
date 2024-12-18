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
        $apiKey = $request->input('apikey');
        $mediaUrl = $request->input('mediaurl');
    
        if (!$mediaUrl || !$apiKey) {
            return response()->json(['error' => 'API key and Media URL are required'], 400);
        }
    
        $curl = curl_init();
    
        curl_setopt_array($curl, [
            CURLOPT_URL => $mediaUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'apikey: ' . $apiKey,
            ],
        ]);
    
        $response = curl_exec($curl);
    
        if ($response === false) {
            return response()->json(['error' => 'cURL error: ' . curl_error($curl)], 500);
        }
    
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE); // Get the content type
        curl_close($curl);
    
        if ($httpStatus != 200) {
            return response()->json(['error' => 'Failed to download media', 'status' => $httpStatus], $httpStatus);
        }
    
        $filename = basename(parse_url($mediaUrl, PHP_URL_PATH));
    
        return response($response)
            ->header('Content-Type', $contentType) // Dynamically set Content-Type
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    //Retrive Header Handle
    public function createSession(Request $request)
    {
        $apiKey = $request->input('apikey');
        // Build the API URL
        $url = "https://partnersv1.pinbot.ai/v3/app/uploads?file_length=164313&file_type=video/mp4";

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
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => [
                'apikey: ' . $apiKey
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

    public function sendLocationMsg(Request $request)
    {
        // dd("hii");
        $apiKey = $request->input('apikey');
        $phoneNumberId = $request->input('phone_number_id'); // Dynamic phone number ID
        $payload = $request->input('payload');

        // dd($apiKey);

        $url = "https://partnersv1.pinbot.ai/v3/$phoneNumberId/messages";

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

    public function sendListMsg(Request $request)
    {
        // dd("hii");
        $apiKey = $request->input('apikey');
        $phoneNumberId = $request->input('phone_number_id'); // Dynamic phone number ID
        $payload = $request->input('payload');

        // dd($apiKey);

        $url = "https://partnersv1.pinbot.ai/v3/$phoneNumberId/messages";

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

    public function sendReplyButton(Request $request)
    {
        // dd("hii");
        $apiKey = $request->input('apikey');
        $phoneNumberId = $request->input('phone_number_id'); // Dynamic phone number ID
        $payload = $request->input('payload');

        // dd($apiKey);

        $url = "https://partnersv1.pinbot.ai/v3/$phoneNumberId/messages";

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

    ///Send Message Template Text
    public function sendMessageTemplateText(Request $request)
    {
        // dd("hii");
        $apiKey = $request->input('apikey');
        $phoneNumberId = $request->input('phone_number_id'); // Dynamic phone number ID
        $payload = $request->input('payload');

        // dd($apiKey);

        $url = "https://partnersv1.pinbot.ai/v3/$phoneNumberId/messages";

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
    //send message apis 
    public function sendMessage(Request $request, $phone_number_id)
    {
        // Validate the incoming request
        $request->validate([
            'to' => 'required|string',
            'type' => 'required|string',
            'text.body' => 'required|string',
            'messaging_product' => 'required|string',
        ]);

        // API URL
        $url = "https://partnersv1.pinbot.ai/v3/{$phone_number_id}/messages";

        // API Key
        $apiKey = $request->input('apikey');

        // Request payload
        $payload = $request->all();

        // Headers
        $headers = [
            'Content-Type: application/json',
            "apikey: {$apiKey}",
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

        // Execute cURL request
        $response = curl_exec($curl);
        $error = curl_error($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Check for errors
        if ($error) {
            return response()->json([
                'status' => 'error',
                'message' => $error,
            ], 500);
        }

        // Decode and return response
        return response()->json([
            'status' => $httpStatus,
            'body' => json_decode($response, true),
        ]);
    }

    public function sendImageMessage(Request $request, $phone_number_id)
    {
        // API URL
        $url = "https://partnersv1.pinbot.ai/v3/{$phone_number_id}/messages";

        // API Key
        $apiKey = $request->input('apikey');

        // Retrieve inputs from the request
        $to = $request->input('to');
        $type = $request->input('type');
        $imageLink = $request->input('image.link');
        $messagingProduct = $request->input('messaging_product');

        // Build payload dynamically
        $payload = [
            'to' => $to,
            'type' => $type,
            'image' => [
                'link' => $imageLink,
            ],
            'messaging_product' => $messagingProduct,
        ];

        // Headers
        $headers = [
            'Content-Type: application/json',
            "apikey: {$apiKey}",
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

        // Execute cURL request
        $response = curl_exec($curl);
        $error = curl_error($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Check for errors
        if ($error) {
            return response()->json([
                'status' => 'error',
                'message' => $error,
            ], 500);
        }

        // Decode and return response
        return response()->json([
            'status' => $httpStatus,
            'body' => json_decode($response, true),
        ]);
    }
    //imp api
    public function sendContactMessage(Request $request)
    {
        // Extract values from the request
        $phoneNumberId = $request->input('phone_number_id');
        $apiKey = $request->input('apikey');

        // Construct the URL
        $url = "https://partnersv1.pinbot.ai/v3/{$phoneNumberId}/messages";

        // Create the headers
        $headers = [
            'Content-Type: application/json',
            "apikey: {$apiKey}",
        ];

        // Construct the payload dynamically from the request input
        $payload = [
            'messaging_product' => $request->input('messaging_product', 'whatsapp'),
            'to' => $request->input('to'),
            'type' => $request->input('type', 'contacts'),
            'contacts' => [
                [
                    'addresses' => [
                        [
                            'street' => $request->input('contacts.0.addresses.0.street'),
                            'city' => $request->input('contacts.0.addresses.0.city'),
                            'state' => $request->input('contacts.0.addresses.0.state'),
                            'zip' => $request->input('contacts.0.addresses.0.zip'),
                            'country' => $request->input('contacts.0.addresses.0.country'),
                            'country_code' => $request->input('contacts.0.addresses.0.country_code'),
                            'type' => $request->input('contacts.0.addresses.0.type', 'HOME'),
                        ]
                    ],
                    'birthday' => $request->input('contacts.0.birthday'),
                    'emails' => [
                        [
                            'email' => $request->input('contacts.0.emails.0.email'),
                            'type' => $request->input('contacts.0.emails.0.type', 'WORK'),
                        ]
                    ],
                    'name' => [
                        'formatted_name' => $request->input('contacts.0.name.formatted_name'),
                        'first_name' => $request->input('contacts.0.name.first_name'),
                        'last_name' => $request->input('contacts.0.name.last_name'),
                        'middle_name' => $request->input('contacts.0.name.middle_name'),
                        'suffix' => $request->input('contacts.0.name.suffix'),
                        'prefix' => $request->input('contacts.0.name.prefix'),
                    ],
                    'org' => [
                        'company' => $request->input('contacts.0.org.company'),
                        'department' => $request->input('contacts.0.org.department'),
                        'title' => $request->input('contacts.0.org.title'),
                    ],
                    'phones' => [
                        [
                            'phone' => $request->input('contacts.0.phones.0.phone'),
                            'wa_id' => $request->input('contacts.0.phones.0.wa_id'),
                            'type' => $request->input('contacts.0.phones.0.type', 'HOME'),
                        ]
                    ],
                    'urls' => [
                        [
                            'url' => $request->input('contacts.0.urls.0.url'),
                            'type' => $request->input('contacts.0.urls.0.type', 'HOME'),
                        ]
                    ],
                ]
            ]
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

        // Execute cURL and get the response
        $response = curl_exec($curl);

        // Check for cURL errors
        if (curl_errno($curl)) {
            return response()->json(['error' => curl_error($curl)], 500);
        }

        curl_close($curl);

        // Return the response
        return response()->json(['response' => json_decode($response)], 200);
    }

    public function sendCarouselMsg(Request $request)
    {
        // dd("hii");
        $apiKey = $request->input('apikey');
        $phoneNumberId = $request->input('phone_number_id'); // Dynamic phone number ID
        $payload = $request->input('payload');

        // dd($apiKey);

        $url = "https://partnersv1.pinbot.ai/v3/$phoneNumberId/messages";

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

    public function sendCatalogMsg(Request $request)
    {
        $apiKey = $request->input('apikey');
        $phoneNumberId = $request->input('phone_number_id'); // Dynamic phone number ID
        $payload = $request->input('payload');

        $url = "https://partnersv1.pinbot.ai/v3/$phoneNumberId/messages";

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
    //send mpm 
    public function sendMpmMessage(Request $request)
    {
        // Validate required headers and key parts of the request
        $request->validate([
            'phone_number_id' => 'required|string',
            'apikey' => 'required|string',
            'body' => 'required|array', // Ensures the body is an array
        ]);

        // Extract data from the request
        $phoneNumberId = $request->input('phone_number_id');
        $apiKey = $request->input('apikey');
        $body = $request->input('body'); // Dynamic body as array

        // API URL
        $url = "https://partnersv1.pinbot.ai/v3/{$phoneNumberId}/messages";

        // Initialize cURL
        $curl = curl_init();

        // Set cURL options
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
            CURLOPT_CUSTOMREQUEST => 'POST', // HTTP POST method
            CURLOPT_HTTPHEADER => [
                'apikey: ' . $apiKey, // Include API key in the header
                'Content-Type: application/json', // Specify the content type as JSON
            ],
            CURLOPT_POSTFIELDS => json_encode($body), // Encode the body as JSON
        ]);

        // Execute the cURL request
        $response = curl_exec($curl);

        // Handle errors if any
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            return response()->json([
                'status' => 'error',
                'message' => $error,
            ], 500);
        }

        // Close the cURL session
        curl_close($curl);

        // Decode the response
        $responseData = json_decode($response, true);

        // Check for success or failure in the response
        if (isset($responseData) && !empty($responseData)) {
            return response()->json([
                'status' => 'success',
                'data' => $responseData,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid response from the server.',
        ], 500);
    }

    //send copy code 
    public function sendCopyCode(Request $request)
    {
        // Retrieve input data from the request
        $phone_number_id = $request->input('phone_number_id');
        $apiKey = $request->input('apikey');
        $payload = $request->input('payload'); // Dynamically retrieve the payload

        // Define the API URL with dynamic phone number ID
        $url = 'https://partnersv1.pinbot.ai/v3/' . $phone_number_id . '/messages';

        // Ensure the 'to' field is present in the payload; if not, add it dynamically
        // if (!isset($payload['to'])) {
        //     $payload['to'] = $recipientnumber;
        // }

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
        if (curl_errno($curl)) {
            return response()->json([
                'status' => 'error',
                'error' => curl_error($curl),
            ], 500);
        }

        // Close cURL
        curl_close($curl);

        // Decode the response and return it
        return response()->json([
            //'status' => 'success',
            'response' => json_decode($response, true),
        ]);
    }

    // Send Template Message//public function sendWhatsAppTemplate(Request $request)
    public function sendTemplateMessage(Request $request)
    {
        // Validate the required headers and key parts of the request
        $request->validate([
            'phone_number_id' => 'required|string',
            'apikey' => 'required|string',
            'body' => 'required|array', // Ensures the body is passed as an array
        ]);
    
        // Extract data from the request
        $phoneNumberId = $request->input('phone_number_id');
        $apiKey = $request->input('apikey');
        $body = $request->input('body'); // Dynamic body as array
    
        // Construct the API URL
        $url = "https://partnersv1.pinbot.ai/v3/{$phoneNumberId}/messages";
    
        // Initialize cURL
        $curl = curl_init();
    
        // Set cURL options
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0, // Disable SSL host verification
            CURLOPT_SSL_VERIFYPEER => 0, // Disable SSL peer verification
            CURLOPT_ENCODING => '', 
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST', // HTTP POST method
            CURLOPT_HTTPHEADER => [
                'apikey: ' . $apiKey, // Include API key in the headers
                'Content-Type: application/json', // Specify the content type as JSON
            ],
            CURLOPT_POSTFIELDS => json_encode($body), // Encode the body as JSON
        ]);
    
        // Execute the cURL request
        $response = curl_exec($curl);
    
        // Check for cURL errors
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            return response()->json([
                'status' => 'error',
                'message' => $error,
            ], 500);
        }
    
        // Close the cURL session
        curl_close($curl);
    
        // Decode the API response
        $responseData = json_decode($response, true);
        // dd($responseData);
    
        // Handle the API response
        if (isset($responseData) && !empty($responseData)) {
            return response()->json([
                'status' => 'success',
                'data' => $responseData,
            ]);
        }
    
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid response from the server.',
        ], 500);
    }
    


    // Send Message Template Interactive
    public function sendMessageTemplateInteractive(Request $request)
    {
        // Retrieve required data from the request
        $phone_number_id = $request->input('phone_number_id');
        //$recipientnumber = $request->input('recipientnumber');
        $apiKey = $request->input('apikey');
        $body = $request->input('body'); // Dynamically retrieve the POST body
        //dd($body);

        // Define the API URL dynamically
        $url = 'https://partnersv1.pinbot.ai/v3/' . $phone_number_id . '/messages';

        // Ensure the 'to' field is present in the body; if not, add it dynamically
        // if (!isset($body['to'])) {
        //     $body['to'] = $recipientnumber;
        // }

        // Initialize cURL
        $curl = curl_init();

        // Set the cURL options
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
                'Content-Type: application/json',
                'apikey: ' . $apiKey,
            ],
            CURLOPT_POSTFIELDS => json_encode($body), // Send the body dynamically
        ]);

        // Execute the cURL request
        $response = curl_exec($curl);

        // Handle cURL errors
        if (curl_errno($curl)) {
            return response()->json([
                'status' => 'error',
                'error' => curl_error($curl),
            ], 500);
        }

        // Close cURL
        curl_close($curl);

        // Decode the API response and return it
        return response()->json([
            'status' => 'success',
            'response' => json_decode($response, true),
        ]);
    }

    //Mark Messages as Read
    public function markMessages(Request $request)
    {
        $apiKey = $request->input('apikey');
        $phoneNumberId = $request->input('phone_number_id'); // Dynamic phone number ID
        $payload = $request->input('payload');

        $url = "https://partnersv1.pinbot.ai/v3/$phoneNumberId/messages";

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

    public function sendMedia(Request $request)
    {
        $apiKey = $request->input('apikey');
        $phoneNumberId = $request->input('phone_number_id'); // Dynamic phone number ID
        $payload = $request->input('payload');

        $url = "https://partnersv1.pinbot.ai/v3/$phoneNumberId/messages";

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
}
