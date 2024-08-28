<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use Telegram\Bot\Laravel\Facades\Telegram;

class SetupNgrokWebhook extends Command
{
    protected $signature = 'app:setup-ngrok-webhook';

    protected $description = 'Command description';

    public function ngrokConfig()
    {
        if (Process::run('ngrok config check')->failed()) {
            $authToken = config('services.ngrok.auth_token');
            Process::run("ngrok config $authToken");
        }
    }

    public function handle()
    {
        $api_key = config('services.ngrok.api_key');

        $this->ngrokConfig();

        $ngrokProcess = Process::forever()->start("ngrok http 8000");

        sleep(5);

        while ($ngrokProcess->running())
        {
            $result = json_decode(Http::withHeaders([
                    'Authorization' => "Bearer $api_key",
                    'Ngrok-Version' => 2,
                ])->get('https://api.ngrok.com/tunnels'), 1);

            $ngrokURL = $result['tunnels'][0]['public_url'];

            Telegram::setWebhook([
                'url' => $ngrokURL,
                'secret_token' => config('telegram.webhook-token'),
            ]);

            $this->info('Webhook is ready!');
            break;
        }
    }
}
