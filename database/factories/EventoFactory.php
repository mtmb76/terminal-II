<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tema;
use App\Models\Unidade;
use App\Models\Participante;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evento>
 */
class EventoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $opts = ['O','C','A'];
        $temas = Tema::count();
        #$unidades = Unidade::count();
        $users = User::count();
        return [
            #'unidade_id' => fake()->numberBetween(1,$unidades),
            'unidade_id' => fake()->numberBetween(1,6),
            'tema_id' =>fake()->numberBetween(1, $temas),
            'user_id' => fake()->numberBetween(1, $users), 
            'dia' => fake()->dateTimeBetween('2023-02-01','2023-02-28'),
            'turno' => fake()->numberBetween(1, 3),
            'area' => $opts[fake()->numberBetween(0, 2)],
        ];
    }
}
