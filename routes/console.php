<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Log::info("Run schedule at" . date('y-m-d-h-i-s'));

Schedule::call(function () {
    Log::info('This job runs every minute or more'); 
});

Schedule::command('queue:work --stop-when-empty')->everySecond();


