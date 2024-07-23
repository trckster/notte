<?php

namespace App\Http\Controllers;

use Telegram\Bot\Laravel\Facades\Telegram;


class TelegramBotCommandsController extends Controller
{
    public function handleCommands()
    {
        Telegram::commandsHandler(true);

        return 'ok';
    }
}
