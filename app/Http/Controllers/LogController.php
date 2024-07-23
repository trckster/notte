<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Context;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class LogController extends Controller
{
    public function logData(Request $request)
    {
        $validated = $request->validate([
            'data' => 'required|filled',
        ]);

        $targetChatId = Context::get('target_chat_id');
        $data = $validated['data'];

        Telegram::sendMessage([
            'chat_id' => $targetChatId,
            'text' => $data,
        ]);
    }
}
