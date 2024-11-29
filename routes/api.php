<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::post('/template-multiple-button/{wabaid}', [UserController::class, 'sendTemplate']);
Route::post('/create-template-carousel/{wabaid}', [UserController::class, 'carouselTemplate']);
Route::post('/create-template-image/{wabaid}', [UserController::class, 'imageTemplate']);
Route::post('/create-template-video/{wabaid}', [UserController::class, 'createTemplateVideo']);
Route::post('/create-template-document/{wabaid}', [UserController::class, 'createTemplateDocument']);


