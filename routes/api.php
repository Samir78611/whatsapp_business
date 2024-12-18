<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleSheetController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/create-user-account',[UserController::class,'userCreateAccount']);

//user details (27-11-2024)
Route::get('get-user-details',[UserController::class,'getUserDetails']);
Route::get('fetch-weba-info/{wabaid}',[UserController::class,'fetchWeba']);


//create template // (29-11-2024)
Route::post('/template-multiple-button/{wabaid}', [UserController::class, 'sendTemplate']);
Route::post('/create-template-carousel/{wabaid}', [UserController::class, 'carouselTemplate']);
Route::post('/create-template-image/{wabaid}', [UserController::class, 'imageTemplate']);
Route::post('/create-template-video/{wabaid}', [UserController::class, 'createTemplateVideo']);
Route::post('/create-template-document/{wabaid}', [UserController::class, 'createTemplateDocument']);
Route::post('create-template-location/{wabaid}',[TemplateController::class,'createTemplateLocation']);
Route::post('create-template-text/{wabaid}',[TemplateController::class,'createTemplateText']);
Route::post('create-template-copy-code/{wabaid}',[TemplateController::class,'createTemplateCopyCode']);
Route::post('create-template-catalog/{wabaid}',[TemplateController::class,'createTemplateCatalog']);
Route::post('create-template-mpm/{wabaid}',[TemplateController::class,'createTemplateMpm']);

//Edit Templates
// (02-12-2024)
Route::post('/edit-template-multiple-button/{msgtemplateid}',[TemplateController::class,'editTemplateMultipleButton']);
Route::post('/edit-template-carousel/{msgtemplateid}',[TemplateController::class,'editTempCarousel']);
Route::post('/edit-template-image/{msgtemplateid}',[TemplateController::class,'editTemplateImage']);
Route::post('/edit-template-video/{msgtemplateid}',[TemplateController::class,'editTemplateVideo']);
Route::post('/edit-template-document/{msgtemplateid}',[TemplateController::class,'editTemplateDocument']);
Route::post('edit-template-location/{msgtemplateid}',[TemplateController::class,'editTemplateLocation']);
Route::post('edit-template-text/{msgtemplateid}',[TemplateController::class,'editTemplateText']);
Route::post('edit-template-copy-code/{msgtemplateid}',[TemplateController::class,'editTemplateCopyCode']);
Route::post('edit-template-catalog/{msgtemplateid}',[TemplateController::class,'editTemplateCatalog']);
Route::post('edit-template-mpm/{msgtemplateid}',[TemplateController::class,'editTemplateMpm']);

//media
Route::post('/upload-media/{phoneNumberId}', [TemplateController::class, 'uploadMediaFile']);
Route::post('/download-media/{mediaId}/{phoneNumberId}', [TemplateController::class, 'downloadMedia']);
Route::delete('/deleteMedia/{mediaId}/{phoneNumberId}', [TemplateController::class, 'deleteMedia']);
Route::get('media/{mediaId}', [MediaController::class, 'getMediaUrl']);
Route::get('download-media', [MediaController::class, 'downloadMedia']);

//initiate upload
Route::post('/upload-file', [UserController::class, 'uploadFile']);
//Retrive Header Handle
Route::post('create-session', [MediaController::class, 'createSession']);

//Send Message template
Route::post('send-carousel-message', [MediaController::class, 'sendCarouselMsg']);
Route::post('send-catalog-message', [MediaController::class, 'sendCatalogMsg']);
Route::post('send-mpm-message', [MediaController::class, 'sendMpmMessage']);
Route::post('send-copy-code', [MediaController::class, 'sendCopyCode']);

Route::post('send-location-message', [MediaController::class, 'sendLocationMsg']);
Route::post('send-list-message', [MediaController::class, 'sendListMsg']);
Route::post('send-reply-button', [MediaController::class, 'sendReplyButton']);
Route::post('send-message-template-text', [MediaController::class, 'sendMessageTemplateText']);
//send message
Route::post('/send-message/{phone_number_id}', [MediaController::class, 'sendMessage']);
Route::post('/send-image-message/{phone_number_id}', [MediaController::class, 'sendImageMessage']);
Route::post('/send-contact-message', [MediaController::class, 'sendContactMessage']);
Route::post('/send-template-message', [MediaController::class, 'sendTemplateMessage']);


//11-12-2024
Route::post('mark-messages-read', [MediaController::class, 'markMessages']);
Route::post('send-messages-media', [MediaController::class, 'sendMedia']);
Route::post('/send-interactive-message',[MediaController::class,'sendMessageTemplateInteractive']);


//webhook 12-12-2024

Route::post('/set-webhook',[WebhookController::class,'setWebhook']);
Route::get('/get-webhook',[WebhookController::class,'getWebhook']);



Route::get('/google-sheet',[CalendarController::class,'fetchSheetData']);
Route::get('/google/auth', [CalendarController::class, 'getAccessToken']);

//calender apis
Route::get('generate-jwt-calendar', [CalendarController::class, 'generateJwt']);
Route::post('create-google-calendar', [CalendarController::class, 'createCalendar']);
Route::post('get-calendar', [CalendarController::class, 'getCalendar']);
Route::post('update-calendar', [CalendarController::class, 'updateCalendar']);
Route::delete('delete-calendar', [CalendarController::class, 'deleteCalendar']);


//Google Sheet
Route::get('/generate-jwt', [GoogleSheetController::class, 'generateJwt']);
Route::get('/google-sheet',[GoogleSheetController::class,'fetchSheetDat']);
Route::post('/google-sheets/data-filter', [GoogleSheetController::class, 'fetchDataByFilter']);
Route::post('/google-sheets/append', [GoogleSheetController::class, 'appendData']);
