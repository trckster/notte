<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Token;

class HasToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $tokenSecret = $request->header('Authorization');

        $validated = $request->validate([
            'data' => 'required|filled',
        ]);

        if (Token::query()->where('secret', $tokenSecret)->first() === null){
            return response('Token was revoked!', 422);
        }

        $token = Token::query()->where('secret', $tokenSecret)->first();
        $data = $validated['data'];

        if ($token->revoked_at) {
            return response('Token was revoked!', 401);
        }

        $request->attributes->add([
            'target_chat_id' => $token->target_chat_id,
            'user_id' => $token->user_id,
            'data' => $validated['data']]);
  


        
        return $next($request);
    }
}
