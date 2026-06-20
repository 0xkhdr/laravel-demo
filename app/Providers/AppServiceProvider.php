<?php

namespace App\Providers;

use App\Services\CacheMetricsService;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register CacheMetricsService as a singleton for performance
        $this->app->singleton(CacheMetricsService::class, function ($app) {
            return new CacheMetricsService();
        });
    }

    public function boot(): void
    {
        // Restrict Horizon dashboard access in non-local environments
        Horizon::auth(function ($request) {
            return app()->environment('local');
        });
    }
}
