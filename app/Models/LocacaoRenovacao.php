<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocacaoRenovacao extends Model
{
    protected $table = 'locacao_renovacaos';
    protected $fillable = [

        'locacao_id',

        'data_anterior',

        'nova_data',

        'valor'

    ];

    public function locacao()
    {
        return $this->belongsTo(Locacao::class);
    }
}

