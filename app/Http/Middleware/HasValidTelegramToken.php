<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasValidTelegramToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $tokenSecret = $request->header('X-Telegram-Bot-Api-Secret-Token');
         
        if ($tokenSecret !== config('telegram.webhook_token'))
        {
            return response('Invalid telegram token!', 401);
        }

        return $next($request);
    }
}
