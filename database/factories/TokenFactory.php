<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Token>
 */
class TokenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id"=> fake()->randomNumber(),
            "target_chat_id" => fake()->randomNumber(),
            "secret" => fake()->text(),
            "created_at" => fake()->date("Y-m-d"),
            "revoked_at"=> fake()->date("Y-m-d"),
        ];
    }
}
