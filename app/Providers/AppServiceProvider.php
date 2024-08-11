<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    protected function boot(): void
    {
        RateLimiter::for('api/log', function (Request $request) {
            return Limit::perMinute(10)->by($request->header('Authorization') ?: $request->ip());
        });
    }
}
