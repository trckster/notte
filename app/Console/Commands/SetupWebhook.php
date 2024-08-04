<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use Telegram\Bot\Laravel\Facades\Telegram;

class SetupWebhook extends Command
{
    protected $signature = 'app:setup-webhook';

    protected $description = 'Command description';

    public function handle()
    {
        $port = config('services.ngrok.forward_port');
        $result = Process::run("ngrok http $port");

        if ($result->successful()) {
            $response = Http::get('http://example.com');
        }

        Telegram::setWebhook([
            'url' => config('telegram.bots.notte.webhook_url'),
            'secret_token' => config('telegram.webhook_token'),
        ]);

        $this->info('Webhook is ready!');
    }
}
