<?php

namespace App\Providers;

use App\Models\ReviewAndRating;
use Illuminate\Support\ServiceProvider;
use App\Observers\ReviewAndRatingObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ReviewAndRating::observe(ReviewAndRatingObserver::class);
    }
}
