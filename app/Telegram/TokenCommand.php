<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Commands\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class TokenCommand extends Command
{
    protected string $name = 'token';
    protected string $description = 'Creates authentication token';

    public function handle()
    {
        $message = $this->getUpdate()->getChat();
        
        $targetChatId = $message->

        $this->replyWithMessage([
            'text' => 'Hey, there! Welcome to our bot!',
        ]);
    }
}