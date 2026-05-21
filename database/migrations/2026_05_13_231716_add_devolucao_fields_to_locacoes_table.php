<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('locacoes', function (Blueprint $table) {

            $table->dateTime('data_devolucao')
                ->nullable();

            $table->decimal('multa', 10, 2)
                ->nullable();

            $table->text('avarias')
                ->nullable();

            $table->text('observacoes_devolucao')
                ->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('locacoes', function (Blueprint $table) {

            $table->dropColumn([
                'data_devolucao',
                'multa',
                'avarias',
                'observacoes_devolucao'
            ]);

        });
    }
};