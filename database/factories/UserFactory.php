<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
#use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'name' => 'Marcelo Tavares',#fake()->name(),
            'email' => 'marcelo.tavares@localfrio.com.br',#fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$5EASOvWfrcWwYSwFpy.2xOFBTXkCyx.2SDJ56M5C7TGkruax1XfAC',#'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => '',#Str::random(10),
            'grupo' => 'admin',
            'ativo' => '1',
            'unidade_id' => 5,#fake()->numberBetween(1,4),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
