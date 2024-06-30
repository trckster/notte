<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $validated = $request->validate([
            'token' => 'required|exists:tokens,secret',
            'data' => 'required|filled',
        ]);

        $token = Token::query()->where('secret', $validated['token'])->first();
        $data = $validated['data'];

        if ($token->revoked_at) {
            return response('Token was revoked!', 401);
        }
        
        return $next($request);
    }
}
