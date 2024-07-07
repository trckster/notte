<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TokenFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => fake()->randomNumber(),
            'target_chat_id' => fake()->randomNumber(),
            'secret' => Str::random(),
            'created_at' => fake()->date(),
            'revoked_at' => null,
        ];
    }
}
