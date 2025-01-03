<?php

use App\Models\Appointmenter;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\BusinessController;
use App\Http\Controllers\Front\AppointmentController;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
