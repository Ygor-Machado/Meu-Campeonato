<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('partidas', function (Blueprint $table) {
            $table->id();

            $table->integer('gols_time_1');
            $table->integer('gols_time_2');

            $table->foreignId('campeonato_id')->constrained('campeonatos');
            $table->foreignId('time_1_id')->constrained('times');
            $table->foreignId('time_2_id')->constrained('times');
            $table->foreignId('fase_id')->constrained('fases');
            $table->foreignId('vencedor_id')->constrained('times');
            $table->foreignId('perdedor_id')->constrained('times');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partidas');
    }
};
