<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\Token;

class LogTest extends TestCase
{
    #[Test]
    public function cantLogUserInvalidToken()
    {
        $secret = fake()->text(10);
        $data = 'TEST_DATA';

        $this->postJson(route('log'), ['data' => $data], [
            'Authorization' => $secret
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
            'Authorization' => $token->secret
        ])->assertStatus(401);
    }

    #[Test]
    public function canLogData()
    {
        $token = Token::factory()->create();

        Log::shouldReceive('info')
            ->withArgs(["{$token->user_id} -> {$token->target_chat_id}: Any data"])
            ->once();

        $this->postJson(route('log'), ['data' => 'Any data'], [
            'Authorization' => $token->secret
        ])->assertStatus(200);
    }
}
