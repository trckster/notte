<?php

namespace App\Telegram;

use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name = 'start';
    protected string $description = 'Start here';

    public function handle()
    {
        $this->replyWithMessage([
            'text' => "Hi!
This bot helps monitoring your application by forwarding HTTP requests to Telegram messages.
In order to send requests you need a token. Obtain it here: /token",
        ]);
    }
}