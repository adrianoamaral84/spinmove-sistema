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
    Schema::create('leads', function (Blueprint $table) {
        $table->id();

        $table->string('telefone')->unique();
        $table->string('nome')->nullable();

        $table->string('status_lead')->default('novo'); // novo, conversando, fechado, perdido

        $table->text('ultima_mensagem')->nullable();

        $table->string('origem')->nullable(); // whatsapp, instagram etc

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
