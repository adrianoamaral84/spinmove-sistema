<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bikes', function (Blueprint $table) {

            $table->decimal('valor_compra', 10, 2)
                ->nullable();

            $table->date('data_compra')
                ->nullable();

           

        });
    }

    public function down(): void
    {
        Schema::table('bikes', function (Blueprint $table) {

            $table->dropColumn([
                'valor_compra',
                'data_compra',
                
            ]);

        });
    }
};
