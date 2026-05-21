<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locacao_renovacaos', function (Blueprint $table) {

            $table->id();
        
            $table->foreignId('locacao_id')
          ->constrained('locacoes')
          ->onDelete('cascade');


            $table->date('data_anterior');

            $table->date('nova_data');

            $table->decimal('valor', 10, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locacao_renovacaos');
    }
};
