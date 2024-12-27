<?php

use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function(){
            Route::prefix('nimda')->group(base_path('routes/admin.php'));
            Route::prefix('business-manager')->group(base_path('routes/business.php'));
            // Route::namespace('admin')->prefix('admin')->name('admin.')->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->append(Admin::class);
        $middleware->alias([
            'admin' => \App\Http\Middleware\Admin::class,
            'business' => \App\Http\Middleware\Business::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
