<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\Token;
class LogTest extends TestCase
{
    #[Test]
    public function WrongToken()
    {
        $token = Token::factory()->create();

        $secret = $token->token;
        $data = 'TEST_DATA';

        $response = $this->post('/log', ['token' => $secret, 'data' => $data]);

        $response->assertStatus(401);
        
    }
}
