<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->string('titulo');
            $table->text('mensagem')->nullable();

            $table->string('nome_cliente')->nullable();
            $table->string('telefone')->nullable();
            $table->unsignedBigInteger('plano_id')->nullable();

            $table->boolean('lida')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};