<?php

use App\Models\Appointmenter;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\AccountController;
use App\Http\Controllers\Front\BusinessController;
use App\Http\Controllers\Front\AppointmentController;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/privacy-policy', 'privacyPolicy')->name('privacyPolicy');
    Route::get('/term-and-condition', 'termAndCondition')->name('termAndCondition');
    Route::get('/copy-right', 'CopyRight')->name('CopyRight');
});

Route::controller(BusinessController::class)->group(function () {
    Route::get('businesses/{slug?}', 'index')->name('business');
    Route::get('business/{slug}', 'businessDetails')->name('business-details');
    Route::post('get-business', 'getBusiness')->name('get-business');
});


Route::controller(AppointmentController::class)->group(function () {
    Route::get('expert/{slug?}', 'index')->name('expert');
    Route::post('book-appointment', 'bookAppointment')->name('book.appointment');
    Route::post('get-appoinmenter-timing', 'getAppoinmenterTiming')->name('get.appoinmenter.timing');
});

// User Authenticated Routes
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'store')->name('login');
    Route::post('Register', 'register')->name('register');
});

Route::middleware(['web', 'front'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('logout', 'destroy')->name('logout');
    });

    Route::controller(BusinessController::class)->group(function () {
        Route::post('business/favorite', 'businessFavorite')->name('businessFavorite');
    });

    Route::controller(AccountController::class)->name('account.')->group(function () {
        Route::get('user-profile', 'userProfile')->name('userprofile');
        Route::post('user-profile/update/{id}', 'userProfileUpdate')->name('userprofile.update');
        Route::get('chnage-password', 'changePassword')->name('changePassword');
        Route::post('chnage-password/update', 'changePasswordUpdate')->name('changePassword.update');
    });
});

// require __DIR__ . '/auth.php';
