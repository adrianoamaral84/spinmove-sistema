<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('locacoes', function (Blueprint $table) {

            $table->foreignId('cliente_id')
                ->nullable()
                ->after('bike_id')
                ->constrained()
                ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::table('locacoes', function (Blueprint $table) {

            $table->dropConstrainedForeignId('cliente_id');

        });
    }
};