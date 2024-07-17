<?php

namespace App\Telegram;

use Telegram\Bot\Commands\Command;
use App\Models\Token;
use Str;

class TokenCommand extends Command 
{
    protected string $name = 'token';
    protected string $description = 'Creates authentication token';

    public function handle()
    {
        $targetChatId = $this->getUpdate()->getChat()->id;
        $userId = $this->getUpdate()->getMessage()->from->id;

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
            'text' => "Your token:\n\n`$secret`\n\nAll the previous tokens were revoked",
            'parse_mode' => 'MarkdownV2',
        ]);
    }
}