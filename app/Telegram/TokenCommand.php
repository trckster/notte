<?php

namespace App\Telegram;

use Telegram\Bot\Commands\Command;
use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TokenCommand extends Command
{
    protected string $name = 'token';
    protected string $description = 'Creates authentication token';

    public function handle()
    {
        $targetChatId = $this->getUpdate()->getChat()->id;
        $userId = $this->getUpdate()->getMessage()->from->id;
        $userName = $this->getUpdate()->getMessage()->from->username ?? $userId;
        $secret = $userName . ':' . Str::random(24);

        Token::query()->where('user_id', $userId)->update([
            'revoked_at' => Carbon::now()
        ]);

        Token::query()
            ->create([
                'target_chat_id' => $targetChatId,
                'user_id' => $userId,
                'secret' => $secret,
            ]);

        $this->replyWithMessage([
            'text' => "Your token:\n\n`$secret`\n\nAll the previous tokens were revoked",
            'parse_mode' => 'MarkdownV2',
        ]);
    }
}
