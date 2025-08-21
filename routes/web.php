<?php

use App\Models\Appointmenter;
use App\Models\AppointmentBooking;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Mail\AppointmentConfirmationMail;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\AccountController;
use App\Http\Controllers\Front\BusinessController;
use App\Http\Controllers\Front\AppointmentController;

// Route::get('test-email', function () {
//     // generateQRCode('sdsddsd');
//     $appointment_details = AppointmentBooking::query()
//         ->select('id', 'token_number', 'business_id', 'appointmenter_id', 'user_id', 'user_name', 'user_contact', 'slot_start_time', 'slot_end_time', 'booking_date', 'note', 'status')
//         ->with([
//             'appontmenter:id,appointmenter_name,slug,is_appointment_book_with_time_slot',
//             'business:id,name,slug,address',
//             'user:id,first_name,email,notification_token'
//         ])
//         ->find(39);

//     Mail::to($appointment_details->user->email)->send(new AppointmentConfirmationMail($appointment_details));
//     echo 'success';
// });

Route::get('landing_page', function () {
    return view('front/landing_page');
});

Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::controller(CommonController::class)->group(function () {
    Route::get('get-areas', 'getAreas')->name('getAreas');
    Route::get('get-location-info', 'getLocationInfo')->name('getLocationInfo');


    Route::get('search', 'getSearch')->name('search');
});
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/faq', 'faq')->name('faq');
    Route::get('/about-us', 'aboutUs')->name('aboutUs');
    Route::get('/contact-us', 'contactUs')->name('contactUs');
    Route::get('/privacy-policy', 'privacyPolicy')->name('privacyPolicy');
    Route::get('/term-and-condition', 'termAndCondition')->name('termAndCondition');
    Route::get('/copy-right', 'CopyRight')->name('CopyRight');
    Route::get('/cancellation-and-refund-policy', 'CancellationAndRefundPolicy')->name('CancellationAndRefundPolicy');
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
    Route::get('expert/board/{slug?}', 'board')->name('expert.board');
});

// User Authenticated Routes
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'store')->name('login');
    Route::post('Register', 'register')->name('register');

    Route::get('/auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('/auth/google/callback', 'handleGoogleCallback')->name('auth.google.callback');


    Route::get('Register-business', 'registerBusinessView')->name('register.business');
    Route::post('Register-business', 'registerBusiness')->name('register.business.store');

    Route::post('forgot-password', 'forgotPassword')->name('forgot.password');
    Route::get('password-reset/{token}/{email}', 'ResetPasswordForm')->name('password.reset');
    Route::post('password-reset', 'ResetPassword')->name('password.reset.update');
});

Route::middleware(['web', 'front'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('logout', 'destroy')->name('logout');
    });

    Route::controller(BusinessController::class)->group(function () {
        Route::post('business/favorite', 'businessFavorite')->name('businessFavorite');
    });

    Route::controller(AccountController::class)->name('account.')->group(function () {
        Route::get('account', 'index')->name('index');
        Route::get('user-profile', 'userProfile')->name('userprofile');
        Route::post('user-profile/update/{id}', 'userProfileUpdate')->name('userprofile.update');
        Route::get('chnage-password', 'changePassword')->name('changePassword');
        Route::post('chnage-password/update', 'changePasswordUpdate')->name('changePassword.update');

        //booking
        Route::get('bookings', 'booking')->name('booking');
        Route::get('get-bookings', 'getBookings')->name('get.booking');
        Route::get('booking/{id}', 'bookingDetails')->name('booking.details');
        Route::post('booking/cancel', 'bookingCancel')->name('booking.cancel');
        Route::post('booking/review', 'bookingReview')->name('booking.review');
    });
});

// require __DIR__ . '/auth.php';
