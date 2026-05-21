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
        Schema::create('conversas', function (Blueprint $table) {
    $table->id();

    $table->string('telefone')->index();
    $table->string('nome')->nullable();

    $table->string('status')->default('novo');
    // novo, atendendo, interessado, fechado, perdido

    $table->text('ultima_mensagem')->nullable();
    $table->timestamp('ultima_mensagem_em')->nullable();

    $table->json('contexto')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversas');
    }
};
