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
        $url = env('TELEGRAM_WEBHOOK_URL');
        Telegram::setWebhook(['url' => $url]);
    }
}
