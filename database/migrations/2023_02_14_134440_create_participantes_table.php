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
        if (!Schema::hasTable('participantes')) {
            Schema::create('participantes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('unidade_id')->constrained('unidades')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
                $table->string('nome');
                $table->string('cpf');
                $table->string('cracha');
                $table->char('ativo');
                $table->string('email');
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
        Schema::dropIfExists('participantes');
    }
};
