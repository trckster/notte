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
        Telegram::setWebhook([
            'url' => config('app.url') . '/api/webhook',
            'secret_token' => config('telegram.webhook-token'),
        ]);

        $this->info('Webhook is ready!');
    }
}
