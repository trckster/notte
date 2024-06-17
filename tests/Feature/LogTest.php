<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\Token;
use TiMacDonald\Log\LogFake;
use Illuminate\Support\Facades\Log;

class LogTest extends TestCase
{
    #[Test]
    public function WrongToken()
    {
        $secret = fake()->text(10);
        $data = 'TEST_DATA';

        $this->postJson(route('log'), ['token' => $secret, 'data' => $data])->assertStatus(422);
        
    }

    #[Test]
    public function revokedToken()
    {
        $token = Token::factory()->create();
        $revokeTime = fake()->date("Y-m-d");

        $data = 'TEST_DATA';

        $token->update([
            'revoked_at' => $revokeTime,
        ]);

        $this->postJson(route('log'), ['token' => $token->secret, 'data' => $data])->assertStatus(401);

    }

    /*#[Test]
    public function loggingWorks()
    {
        $token = Token::factory()->create();
        $data = 'TEST_DATA';

        $fakeLog = 

        $this->postJson(route('log'), ['token' => $token->secret,'data'=> $data])->assertOk;
    }*/
}
