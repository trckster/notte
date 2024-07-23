<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Telegram\Bot\Laravel\Facades\Telegram;
use Tests\TestCase;
use App\Models\Token;

class LogTest extends TestCase
{
    #[Test]
    public function cantLogUserInvalidToken()
    {
        $secret = Str::random();
        $data = 'TEST_DATA';

        $this->postJson(route('log'), ['data' => $data], [
            'Authorization' => "Bearer $secret"
        ])->assertStatus(422);
    }

    #[Test]
    public function cantLogUsingRevokedToken()
    {
        $data = 'TEST_DATA';

        $token = Token::factory()->create([
            'revoked_at' => fake()->date(),
        ]);

        $this->postJson(route('log'), ['data' => $data], [
            'Authorization' => "Bearer {$token->secret}"
        ])->assertStatus(401);
    }

    // Test is inactive until library class BotManager fixes that should remove 'final'
    public function canSendDataToTelegram()
    {
        $token = Token::factory()->create();

        Telegram::shouldReceive('sendMessage')
            ->withArgs([['chat_id' => $token->target_chat_id, 'text' => 'Any data']])
            ->once();

        $this->postJson(route('log'), ['data' => 'Any data'], [
            'Authorization' => "Bearer {$token->secret}"
        ])->assertStatus(200);
    }
}
