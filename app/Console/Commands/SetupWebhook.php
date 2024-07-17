<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;
use Str;

class SetupWebhook extends Command
{
    protected $signature = 'app:setup-webhook';

    protected $description = 'Command description';

    public function handle()
    {
        var_dump(config('telegram.webhook_token'));
        Telegram::setWebhook(
            [
                'url' => config('telegram.bots.mybot.webhook_url'),
                'secret_token' => config('telegram.webhook_token'),
            ]
        );
    }
}
