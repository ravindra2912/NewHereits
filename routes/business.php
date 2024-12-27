<?php

use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Business\AuthController;
use App\Http\Controllers\Business\SettingController;
use App\Http\Controllers\Business\DashboarController;
use App\Http\Controllers\Business\AppointmenterController;
use App\Http\Controllers\Business\AppointmentBookingController;
use App\Http\Controllers\Business\AppointmentDepartmentController;

Route::name('business.')->group(function () {
    Route::middleware('web', 'guest')->group(function () {

        Route::controller(AuthController::class)->group(function () {
            Route::get('login', 'index')->name('login');
            Route::post('login', 'store')->name('login');
        });
    });

    Route::middleware(['web', 'business'])->group(function () {
        Route::controller(DashboarController::class)->group(function () {
            Route::get('dashboard', 'index')->name('dashboard');
        });

        Route::name('appointment.')->group(function () {
            Route::resource('bookings', AppointmentBookingController::class);
            Route::controller(AppointmentBookingController::class)->group(function () {
                Route::post('bookings/get-appoinmenter', 'getAppoinmenterByDepartment')->name('bookings.get.appointmrnter');
                Route::post('bookings/get-appoinmenter-timing', 'getAppoinmenterTiming')->name('bookings.get.appointmrnter.timing');
            });
            Route::resource('department', AppointmentDepartmentController::class);

            Route::resource('appointmenter', AppointmenterController::class);
            Route::controller(AppointmenterController::class)->group(function () {
                Route::get('appointmenter/timing/{id}', 'timing')->name('appointmenter.timing');
                Route::post('appointmenter/timing/{id}', 'timingStore')->name('appointmenter.timing.store');
                Route::post('appointmenter/Timingdestroy', 'TimingDestroy')->name('appointmenter.timing.destroy');
            });
        });

        Route::controller(SettingController::class)->group(function () {
            Route::get('setting/profile', 'profile')->name('setting.profile');
            Route::post('setting/profile/{id}', 'profileUpdate')->name('setting.profile.update');
            Route::get('setting/business/profile', 'businessProfile')->name('setting.business');
            Route::post('setting/business/profile/{id}', 'businessUpdate')->name('setting.business.update');
            Route::get('setting/business/timings', 'businessTiming')->name('setting.business.timing');
            Route::post('setting/business/timings/add', 'businessTimingStore')->name('setting.business.timing.add');
            Route::post('setting/business/timings/remove', 'businessTimingSestroy')->name('setting.business.timing.remove');
            Route::get('setting/business/system-setting', 'systemSetting')->name('setting.systemsetting');
            Route::post('setting/business/system-setting', 'systemSettingUpdate')->name('setting.systemsetting.update');
            Route::get('switch-business/{id}', 'switchBusiness')->name('switchBusiness');
        });

        Route::controller(AuthController::class)->group(function () {
            Route::get('logout', 'destroy')->name('logout');
        });
    });
});
