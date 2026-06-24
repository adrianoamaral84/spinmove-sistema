<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('locacao_eventos', function (Blueprint $table) {

            $table->renameColumn(
                'locacoes_id',
                'locacao_id'
            );

        });
    }

    public function down(): void
    {
        Schema::table('locacao_eventos', function (Blueprint $table) {

            $table->renameColumn(
                'locacao_id',
                'locacoes_id'
            );

        });
    }
};
