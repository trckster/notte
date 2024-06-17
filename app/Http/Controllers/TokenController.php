<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class TokenController extends Controller
{
    public function logData(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|exists:tokens,secret',
            'data' => 'required|filled',
        ]);


        $token = Token::query()->where('secret',$validated['token'])->first();
        $data = $validated['data'];

        if ($token->revoked_at !== null) {
            return response('Data is not valid!', 401);
        }

        Log::info("{$token->user_id} -> {$token->target_chat_id}: {$data}");
        
    }
}
