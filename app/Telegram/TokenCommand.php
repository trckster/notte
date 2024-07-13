<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Commands\Command;
use Telegram\Bot\Commands\CommandInterface;
use App\Models\Token;
use Str;

class TokenCommand extends Command 
{
    protected string $name = 'token';
    protected string $description = 'Creates authentication token';

    public function handle()
    {
        $chat = $this->getUpdate()->getChat();

        $targetChatId = $chat->get('id');
        $userId = $this->getUpdate()->getMessage()->get('user')->id;
        $secret = $userId . ':' . Str::random(24);
        

        Token::query()
                ->create(
                    [
                        'target_chat_id' => $targetChatId,
                        'user_id' => $userId,
                        'secret' => $secret,
                    ]
                    );

        $this->replyWithMessage([
            'text' => 'Hey, there! Welcome to our bot!',
        ]);
    }
}