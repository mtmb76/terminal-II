<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Evento;
use App\Models\Participante;
use App\Models\Tema;
use App\Models\Unidade;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        # seed em unidades 
        ############################################### roda primeiro isso aqui
        Unidade::factory()->create([
            'descricao' => 'Itajaí',
        ]);
        Unidade::factory()->create([
            'descricao' => 'Escritório Central',
        ]);
        Unidade::factory()->create([
            'descricao' => 'Guarujá Terminal I',
        ]);
        Unidade::factory()->create([
            'descricao' => 'Guarujá Terminal II',
        ]);        
       Unidade::factory()->create([
            'descricao' => 'Suape Terminal I',
        ]);
        Unidade::factory()->create([
            'descricao' => 'Suape Terminal II',
        ]);
        Unidade::factory()->create([
            'descricao' => 'Suape Transportadora',
        ]);         

        # seed em usuários
        User::factory(1)->create();

        #seed em temas
        Tema::factory(20000)->create();

        #seed de participantes
        Participante::factory(10000)->create();
        
        #seed de eventos
        Evento::factory(0)->create();        

    }
}