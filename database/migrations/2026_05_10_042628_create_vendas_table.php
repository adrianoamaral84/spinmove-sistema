<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendas', function (Blueprint $table) {

            $table->id();

            $table->foreignId('bike_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->decimal('valor', 10, 2);

            $table->string('cliente')->nullable();

            $table->text('observacoes')->nullable();

            $table->timestamp('data_venda');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendas');
    }
};