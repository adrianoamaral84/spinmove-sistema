<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locacoes', function (Blueprint $table) {

            $table->id();

            $table->foreignId('bike_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('cliente');

            $table->string('telefone')->nullable();

            $table->decimal('valor_mensal', 10, 2);

            $table->date('data_inicio')->nullable();

            $table->date('data_vencimento')->nullable();

            $table->enum('status', [
                'aguardando_entrega',
                'ativa',
                'finalizada',
                'aguardando_retirada',
                'atrasada'
            ])->default('aguardando_entrega');

            $table->text('observacoes')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locacoes');
    }
};