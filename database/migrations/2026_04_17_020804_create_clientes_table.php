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
        Schema::create('clientes', function (Blueprint $table) {
        $table->id();
        $table->string('nome');
        $table->string('telefone');
        $table->string('endereco');
        $table->string('bairro');
        $table->string('cpf', 11)->unique();
        $table->string('estado_civil');
        $table->string('profissao');
        $table->string('email');
        $table->decimal('altura', 3, 2);
        $table->string('origem');
        $table->string('plano');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
