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

<<<<<<< HEAD
//Nikita Apis (29-11-2024)
Route::post('create-template-location/{wabaid}',[TemplateController::class,'createTemplateLocation']);
Route::post('create-template-text/{wabaid}',[TemplateController::class,'createTemplateText']);
Route::post('create-template-copy-code/{wabaid}',[TemplateController::class,'createTemplateCopyCode']);
Route::post('create-template-catalog/{wabaid}',[TemplateController::class,'createTemplateCatalog']);
Route::post('create-template-mpm/{wabaid}',[TemplateController::class,'createTemplateMpm']);
=======
Route::post('/template-multiple-button/{wabaid}', [UserController::class, 'sendTemplate']);
Route::post('/create-template-carousel/{wabaid}', [UserController::class, 'carouselTemplate']);
Route::post('/create-template-image/{wabaid}', [UserController::class, 'imageTemplate']);
Route::post('/create-template-video/{wabaid}', [UserController::class, 'createTemplateVideo']);
Route::post('/create-template-document/{wabaid}', [UserController::class, 'createTemplateDocument']);


>>>>>>> de63665637f3465dd10fe98b31f6717da4cf1c01
