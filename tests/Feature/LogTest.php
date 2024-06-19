<?php

namespace Tests\Feature;

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

        $this->postJson(route('log'), ['token' => $secret, 'data' => $data])->assertStatus(422);
        
    }

    #[Test]
    public function cantLogUsingRevokedToken()
    {
        $data = 'TEST_DATA';

        $token = Token::factory()->create([
            'revoked_at' => fake()->date(),
        ]);

        $this->postJson(route('log'), ['token' => $token->secret, 'data' => $data])->assertStatus(401);

    }
}
