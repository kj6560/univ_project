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
Route::post('/setProfile', [MiscController::class, 'setProfile'])->middleware('auth:api');
Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);