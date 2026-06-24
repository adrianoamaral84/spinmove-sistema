<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class LocacaoRenovacao extends Model
{
    use HasUuid;
    protected $table = 'locacao_renovacaos';
    protected $fillable = [

        'locacao_id',

        'data_anterior',

        'nova_data',

        'valor',

        'plano_id',

        'plano_nome'

    ];

    public function locacao()
    {
        return $this->belongsTo(Locacao::class);
    }

    public function plano()
{
    return $this->belongsTo(Plano::class);
}
}

