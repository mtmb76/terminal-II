<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('eventoparticipantes')) {
            Schema::create('eventoparticipantes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('unidade_id')->constrained('unidades')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('evento_id')->constrained('eventos')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('participante_id')->constrained('participantes')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eventoparticipantes');
    }
};
