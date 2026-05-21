<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('locacoes', function (Blueprint $table) {

            $table->foreignId('plano_id')
                ->nullable()
                ->after('cliente_id')
                ->constrained()
                ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::table('locacoes', function (Blueprint $table) {

            $table->dropConstrainedForeignId('plano_id');

        });
    }
};
