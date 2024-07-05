<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogController extends Controller
{
    public function logData(Request $request)
    {
        Log::info("{$request->get('user_id')} -> {$request->get('target_chat_id')}: {$request->get('data')}");
    }
}
