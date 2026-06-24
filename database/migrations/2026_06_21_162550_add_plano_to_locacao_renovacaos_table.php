<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('locacao_renovacaos', function (Blueprint $table) {

            
            $table->string('plano_nome')
                ->nullable()
                ->after('plano_id');

        });
    }

    public function down(): void
    {
        Schema::table('locacao_renovacaos', function (Blueprint $table) {

            

            $table->dropColumn([
                
                'plano_nome'
            ]);

        });
    }
};
