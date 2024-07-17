<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class SetupWebhook extends Command
{
    protected $signature = 'app:setup-webhook';

    protected $description = 'Command description';

    public function handle()
    {
        Telegram::setWebhook(
            [
                'url' => config('telegram.bots.notte.webhook_url'),
                'secret_token' => config('telegram.webhook_token'),
            ]
        );
    }
}
