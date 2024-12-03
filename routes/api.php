<?php

use App\Http\Controllers\TemplateController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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