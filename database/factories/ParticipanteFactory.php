<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Participante>
 */
class ParticipanteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'nome' => fake()->name(),
            'cpf' => fake()->randomNumber(9),
            'email' => fake()->unique()->safeEmail(),
            'ativo' => fake()->numberBetween(0, 1),
            'cracha' => fake()->randomNumber(5),
            'unidade_id' =>fake()->numberBetween(1, 4),
            'user_id' => fake()->numberBetween(1, 1),
        ];
    }
}
