<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Restrict Horizon dashboard access in non-local environments
        Horizon::auth(function ($request) {
            return app()->environment('local');
        });
    }
}
