<?php

use App\Http\Controllers\site\AdminController;
use App\Http\Controllers\site\SiteController;
use Illuminate\Support\Facades\Route;


Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/login', [SiteController::class, 'login'])->name('login');
Route::post('/loginAuthentication', [SiteController::class, 'loginAuthentication'])->name('loginAuthentication');
Route::get('/register', [SiteController::class, 'register'])->name('register');
Route::post('/subscribe', [SiteController::class, 'subscribe'])->name('subscribe');
Route::post('/createUser', [SiteController::class, 'createUser'])->name('createUser');
Route::get('/logout', [SiteController::class, 'logout'])->name('logout');
Route::get('/forgotPassword', [SiteController::class, 'forgot'])->name('forgot');
Route::get('/reset', [SiteController::class, 'resetPassword'])->name('resetPassword');
Route::post('/forgotPasswordUser', [SiteController::class, 'forgotPasswordUser'])->name('forgotPasswordUser');
Route::post('/resetPasswordUser', [SiteController::class, 'resetPasswordUser'])->name('resetPasswordUser');
Route::get('/about', [SiteController::class, 'about'])->name('about');
Route::get('/event', [SiteController::class, 'event'])->name('event');
Route::get('/eventDetails/{id}', [SiteController::class, 'eventDetails'])->name('eventDetails');
Route::get('/gallery', [SiteController::class, 'gallery'])->name('gallery');
Route::get('/contactus', [SiteController::class, 'contactus'])->name('contactus');
Route::post('/registerNow', [SiteController::class, 'registerNow'])->name('registerNow');
Route::get('/team/{id}', [SiteController::class, 'teamInfo'])->name('teamInfo');

//admin routes
Route::get('/dashboard', [AdminController::class, 'index'])->middleware('auth:web')->name('dashboard');
//category
Route::get('/dashboard/createCategory', [AdminController::class, 'createCategory'])->middleware('auth:web')->name('createCategory');
Route::post('/dashboard/storeCategory', [AdminController::class, 'storeCategory'])->middleware('auth:web')->name('storeCategory');
Route::get('/dashboard/categoryList', [AdminController::class, 'categoryList'])->middleware('auth:web')->name('categoryList');
Route::get('/dashboard/deleteCategory/{id}', [AdminController::class, 'deleteCategory'])->middleware('auth:web')->name('deleteCategory');

//events

Route::get('/dashboard/createEvents', [AdminController::class, 'createEvents'])->middleware('auth:web')->name('createEvents');
Route::get('/dashboard/editEvents/{id}', [AdminController::class, 'editEvents'])->middleware('auth:web')->name('editEvents');
Route::post('/dashboard/storeEvent', [AdminController::class, 'storeEvent'])->middleware('auth:web')->name('storeEvent');
Route::get('/dashboard/eventsList', [AdminController::class, 'eventsList'])->middleware('auth:web')->name('eventList');
Route::get('/dashboard/deleteEvent/{id}', [AdminController::class, 'deleteEvent'])->middleware('auth:web')->name('deleteEvent');

//Event users

Route::get('/dashboard/eventUsers', [AdminController::class, 'eventUsers'])->middleware('auth:web')->name('eventUsers');
Route::get('/dashboard/downloadEventUsers', [AdminController::class, 'downloadEventUsers'])->middleware('auth:web')->name('downloadEventUsers');

//event gallery

Route::get('/dashboard/eventGallery', [AdminController::class, 'eventGallery'])->middleware('auth:web')->name('eventGallery');

Route::get('/dashboard/eventGalleryUploads', [AdminController::class, 'eventGalleryUploads'])->middleware('auth:web')->name('eventGalleryUploads');