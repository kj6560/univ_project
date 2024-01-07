<?php

use App\Http\Controllers\site\AdminController;
use App\Http\Controllers\site\SiteController;
use Illuminate\Support\Facades\Route;


Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/login', [SiteController::class, 'login'])->name('login');
Route::get('/privacy', [SiteController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::get('/deleteRequests', [SiteController::class, 'deleteRequests'])->name('deleteRequests');
Route::post('/requestDelete', [SiteController::class, 'requestDelete'])->name('requestDelete');

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
Route::get('/server', [AdminController::class, 'server'])->middleware('auth:web')->name('server');

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
Route::get('/dashboard/addEventGallery', [AdminController::class, 'addEventGallery'])->middleware('auth:web')->name('addEventGallery');
Route::post('/dashboard/storeEventGallery', [AdminController::class, 'storeEventGallery'])->middleware('auth:web')->name('storeEventGallery');
//Email Templates

Route::get('/dashboard/emailTemplates', [AdminController::class, 'emailTemplates'])->middleware('auth:web')->name('emailTemplates');
Route::get('/dashboard/createEmailTemplates', [AdminController::class, 'createEmailTemplates'])->middleware('auth:web')->name('createEmailTemplates');
Route::get('/dashboard/editEmailTemplates/{id}', [AdminController::class, 'editEmailTemplates'])->middleware('auth:web')->name('editEmailTemplates');
Route::get('/dashboard/deleteEmailTemplates/{id}', [AdminController::class, 'deleteEmailTemplates'])->middleware('auth:web')->name('deleteEmailTemplates');
Route::post('/dashboard/storeEmailTemplates', [AdminController::class, 'storeEmailTemplates'])->middleware('auth:web')->name('storeEmailTemplates');

//users 

Route::get('/userProfile', [SiteController::class, 'userProfile'])->middleware('auth:web')->name('userProfile');
Route::post('/userUpdateContactDetails', [SiteController::class, 'updateContactDetails'])->middleware('auth:web')->name('userUpdateContactDetails');
Route::post('/userUpdatePersonalDetails', [SiteController::class, 'userUpdatePersonalDetails'])->middleware('auth:web')->name('userUpdatePersonalDetails');
Route::post('/userUpdateEmergencyDetails', [SiteController::class, 'userUpdateEmergencyDetails'])->middleware('auth:web')->name('userUpdateEmergencyDetails');
Route::post('/userUpdateProfilePic', [SiteController::class, 'userUpdateProfilePic'])->middleware('auth:web')->name('userUpdateProfilePic');


//site settings

Route::get('/dashboard/siteSettingsList', [AdminController::class, 'siteSettingsList'])->middleware('auth:web')->name('siteSettingsList');
Route::get('/dashboard/createSettings', [AdminController::class, 'createSettings'])->middleware('auth:web')->name('createSettings');
Route::post('/dashboard/storeSettings', [AdminController::class, 'storeSettings'])->middleware('auth:web')->name('storeSettings');
Route::get('/dashboard/editSettings/{id}', [AdminController::class, 'editSettings'])->middleware('auth:web')->name('editSettings');
Route::get('/dashboard/deleteSettings/{id}', [AdminController::class, 'deleteSettings'])->middleware('auth:web')->name('deleteSettings');


//event sliders

Route::get('/dashboard/eventSliders', [AdminController::class, 'eventSliders'])->middleware('auth:web')->name('eventSliders');
Route::get('/dashboard/createSlider', [AdminController::class, 'createSlider'])->middleware('auth:web')->name('createSlider');
Route::post('/dashboard/storeSlider', [AdminController::class, 'storeSlider'])->middleware('auth:web')->name('storeSlider');
Route::get('/dashboard/editSlider/{id}', [AdminController::class, 'editSlider'])->middleware('auth:web')->name('editSlider');
Route::get('/dashboard/deleteSlider/{id}', [AdminController::class, 'deleteSlider'])->middleware('auth:web')->name('deleteSlider');

//users from admin
Route::get('/dashboard/editUser/{id}', [AdminController::class, 'edituser'])->middleware('auth:web')->name('edituser');
Route::post('/dashboard/storeUser', [AdminController::class, 'storeUser'])->middleware('auth:web')->name('storeUser');
Route::get('/dashboard/users', [AdminController::class, 'users'])->middleware('auth:web')->name('users');
Route::get('/dashboard/userActivityLog', [AdminController::class, 'userActivityLog'])->middleware('auth:web')->name('userActivityLog');
Route::get('/dashboard/deleteUser/{id}', [AdminController::class, 'deleteUser'])->middleware('auth:web')->name('deleteUser');


//user  personal details for admin
Route::get('/dashboard/editUserPersonalDetails/{id}', [AdminController::class, 'editUserPersonalDetails'])->middleware('auth:web')->name('editUserPersonalDetails');
Route::post('/dashboard/storeUserPersonalDetails', [AdminController::class, 'storeUserPersonalDetails'])->middleware('auth:web')->name('storeUserPersonalDetails');
Route::get('/dashboard/userPersonalDetails', [AdminController::class, 'userPersonalDetails'])->middleware('auth:web')->name('userPersonalDetails');
Route::get('/dashboard/deleteUserPersonalDetails/{id}', [AdminController::class, 'deleteUserPersonalDetails'])->middleware('auth:web')->name('deleteUserPersonalDetails');


// user activity log for admin
Route::get('/dashboard/userActivityLog', [AdminController::class, 'userActivityLog'])->middleware('auth:web')->name('userActivityLog');
Route::get('/dashboard/appException', [AdminController::class, 'appException'])->middleware('auth:web')->name('appException');

//user Address Details
Route::get('/dashboard/userAddressDetails', [AdminController::class, 'userAddressDetails'])->middleware('auth:web')->name('userAddressDetails');
Route::get('/dashboard/editUserAddressDetails/{id}', [AdminController::class, 'editUserAddressDetails'])->middleware('auth:web')->name('editUserAddressDetails');
Route::post('/dashboard/storeUserAddressDetails', [AdminController::class, 'storeUserAddressDetails'])->middleware('auth:web')->name('storeUserAddressDetails');
Route::get('/dashboard/deleteUserAddressDetails/{id}', [AdminController::class, 'deleteUserAddressDetails'])->middleware('auth:web')->name('deleteUserAddressDetails');

//user Emergency Details
Route::get('/dashboard/userEmergencyDetails', [AdminController::class, 'userEmergencyDetails'])->middleware('auth:web')->name('userEmergencyDetails');
Route::get('/dashboard/editUserEmergencyDetails/{id}', [AdminController::class, 'editUserEmergencyDetails'])->middleware('auth:web')->name('editUserEmergencyDetails');
Route::post('/dashboard/storeUserEmergencyDetails', [AdminController::class, 'storeUserEmergencyDetails'])->middleware('auth:web')->name('storeUserEmergencyDetails');
Route::get('/dashboard/deleteUserEmergencyDetails/{id}', [AdminController::class, 'deleteUserEmergencyDetails'])->middleware('auth:web')->name('deleteUserEmergencyDetails');

//site gallery
Route::get('/dashboard/siteGallery', [AdminController::class, 'siteGallery'])->middleware('auth:web')->name('siteGallery');
Route::get('/dashboard/addGallery', [AdminController::class, 'addGallery'])->middleware('auth:web')->name('addGallery');
Route::post('/dashboard/storeGallery', [AdminController::class, 'storeGallery'])->middleware('auth:web')->name('storeGallery');


//event result
Route::get('/dashboard/eventResults', [AdminController::class, 'eventResults'])->middleware('auth:web')->name('eventResults');
Route::post('/dashboard/storeEventResults', [AdminController::class, 'storeEventResults'])->middleware('auth:web')->name('storeEventResults');
Route::get('/dashboard/processEventResults', [AdminController::class, 'processEventResults'])->middleware('auth:web')->name('processEventResults');
Route::get('/dashboard/downloadResultTemplate', [AdminController::class, 'downloadResultTemplate'])->middleware('auth:web')->name('downloadResultTemplate');