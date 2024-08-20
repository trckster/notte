<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        RateLimiter::for('log', function (Request $request) {
            return Limit::perMinute(1)->by($request->header('Authorization') ?: $request->ip())->response(function (Request $request, array $headers) {
                return response('Custom response...', 429);;
        });
    });
    }
}
