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
    Schema::create('bikes', function (Blueprint $table) {

        $table->id();

        $table->string('codigo')->unique();

        $table->string('modelo');

        $table->string('marca')->nullable();

        $table->enum('status', [

            'disponivel',
            'alugada',
            'manutencao',
            'reservada',
            'inativa'

        ])->default('disponivel');

        $table->text('observacoes')->nullable();

        $table->date('ultima_manutencao')->nullable();

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bikes');
    }
};
