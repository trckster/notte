<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Token;

class HasToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $tokenSecret = explode('Bearer ', $request->header('Authorization'))[1];

        $token = Token::query()->where('secret', $tokenSecret)->first();

        if ($token === null){
            return response('Token was revoked!', 422);
        }

        if ($token->revoked_at) {
            return response('Token was revoked!', 401);
        }

        Context::add(
            [
                'user_id' => $token->user_id,
                'target_chat_id' => $token->target_chat_id,
            ]
        );
  

        return $next($request);
    }
}
