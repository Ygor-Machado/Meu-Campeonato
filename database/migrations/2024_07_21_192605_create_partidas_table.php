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

            $table->integer('gols_time1');
            $table->integer('gols_time2');

            $table->foreignId('campeonato_id')->constrained('campeonatos');
            $table->foreignId('time1_id')->constrained('times');
            $table->foreignId('time2_id')->constrained('times');

            $table->foreignId('vencedor_id')->nullable()->constrained('times');
            $table->foreignId('perdedor_id')->nullable()->constrained('times');

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
