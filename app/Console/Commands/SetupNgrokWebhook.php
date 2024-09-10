<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use Telegram\Bot\Laravel\Facades\Telegram;

class SetupNgrokWebhook extends Command
{
    protected $signature = 'app:setup-ngrok-webhook';

    protected $description = 'Launch ngrok and set up Telegram webhook';

    public function handle()
    {
        $this->setUpNgrok();

        $ngrokProcess = Process::forever()->start('ngrok http 80');

        sleep(5);

        if (!$ngrokProcess->running()) {
            $this->error('Ngrok failed to start');
            $this->error($ngrokProcess->latestErrorOutput());

            return 1;
        }

        $tunnels = Http::withHeaders(['Content-Type' => 'application/json'])
            ->get('http://127.0.0.1:4040/api/tunnels')
            ->json('tunnels');

        $telegramWebhook = $tunnels[0]['public_url'] . '/api/webhook';

        Telegram::setWebhook([
            'url' => $telegramWebhook,
            'secret_token' => config('telegram.webhook-token'),
        ]);

        $this->info('Webhook is ready!');
    }

    private function setUpNgrok(): void
    {
        if (Process::run('ngrok config check')->failed()) {
            $authToken = config('services.ngrok.auth_token');
            Process::run("ngrok config add-authtoken $authToken");
        }
    }
}
