<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('locacao_renovacaos', function (Blueprint $table) {

            $table->foreignId('plano_id')
                  ->nullable()
                  ->after('locacao_id')
                  ->constrained('planos');

        });
    }

    public function down(): void
    {
        Schema::table('locacao_renovacaos', function (Blueprint $table) {

            $table->dropForeign(['plano_id']);
            $table->dropColumn('plano_id');

        });
    }
};
