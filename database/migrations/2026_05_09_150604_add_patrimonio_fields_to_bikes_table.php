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
    Schema::table('bikes', function (Blueprint $table) {

        $table->enum('status_patrimonial', [

            'ativa',
            'vendida',
            'descartada',
            'roubada',

        ])->default('ativa');

        $table->date('data_venda')->nullable();

        $table->decimal('valor_venda', 10, 2)->nullable();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bikes', function (Blueprint $table) {
            //
        });
    }
};
