<?php

use App\Http\Controllers\Api\EventsController;
use App\Http\Controllers\Api\PassportAuthController;
use App\Http\Controllers\Api\SportsController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\MiscController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/home', HomeController::class)->middleware('auth:api');
Route::apiResource('/sports', SportsController::class)->middleware('auth:api');
Route::apiResource('/events', EventsController::class)->middleware('auth:api');
Route::get('/sliders', [MiscController::class, 'getSliders'])->middleware('auth:api');
Route::post('/logException', [MiscController::class, 'logException'])->name('logException');
Route::get('/siteSettings', [MiscController::class, 'getSiteSettings'])->middleware('auth:api');
Route::get('/eventPartners', [MiscController::class, 'getEventPartners'])->middleware('auth:api');
Route::get('/userFiles', [MiscController::class, 'getUserFiles'])->middleware('auth:api');
Route::get('/eventFiles', [MiscController::class, 'getEventFiles'])->middleware('auth:api');
Route::post('/uploadProfilePicture', [MiscController::class, 'uploadProfilePicture'])->middleware('auth:api');
Route::post('/userImageUpload', [MiscController::class, 'userImageUpload'])->middleware('auth:api');
Route::post('/registerNow', [MiscController::class, 'registerNow'])->name('registerNow');
Route::post('/uploadUserVideos', [MiscController::class, 'uploadUserVideos'])->middleware('auth:api');
Route::get('/userPerformance', [MiscController::class, 'getUserPerformance'])->middleware('auth:api');
Route::post('/setProfile', [MiscController::class, 'setProfile'])->middleware('auth:api');
Route::post('register', [PassportAuthController::class, 'register']);
Route::post('/sendEmailOtp', [PassportAuthController::class, 'sendEmailOtp']);
Route::post('/resetPassword', [PassportAuthController::class, 'resetPassword']);
Route::post('login', [PassportAuthController::class, 'login']);
Route::post('logout', [PassportAuthController::class, 'logout']);