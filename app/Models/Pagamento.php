<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $fillable = [
    'cliente_id',
    'locacao_id',
    'valor',
    'data_pagamento',
    'forma_pagamento',
    'parcelas',
    'status',
    'tipo',
    'cobranca_id',
    'observacao'
    
    
];

public function cliente()
{
    return $this->belongsTo(\App\Models\Cliente::class);
}

public function locacao()
{
    return $this->belongsTo(\App\Models\Locacao::class);
}

}
