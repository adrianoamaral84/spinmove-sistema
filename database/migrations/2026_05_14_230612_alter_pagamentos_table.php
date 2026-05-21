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
        Schema::table('pagamentos', function (Blueprint $table) {

    
    

    


    $table->integer('parcelas')
        ->default(1)
        ->after('forma_pagamento');

    $table->enum('status', [

        'pago',
        'pendente',
        'cancelado'

    ])->default('pago')
      ->after('parcelas');

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
