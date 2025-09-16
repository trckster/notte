<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use Telegram\Bot\Laravel\Facades\Telegram;

class SetupWebhook extends Command
{
    protected $signature = 'app:setup-webhook';

    protected $description = 'Set up Telegram webhook & launch ngrok if ngrok token if present';

    public function handle(): void
    {
        $baseUrl = config('app.url');

        if (config('services.ngrok.auth_token')) {
            $baseUrl = $this->launchNgrok();
        }

        $telegramWebhook = $baseUrl . '/api/webhook';

        Telegram::setWebhook([
            'url' => $telegramWebhook,
            'secret_token' => config('telegram.webhook-token'),
        ]);

        $this->info("Webhook is ready at $telegramWebhook");
    }

    private function launchNgrok(): string
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

        return $tunnels[0]['public_url'];
    }

    private function setUpNgrok(): void
    {
        if (Process::run('ngrok config check')->failed()) {
            $authToken = config('services.ngrok.auth_token');
            Process::run("ngrok config add-authtoken $authToken");
        }
    }
}
