<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Plano;
use App\Traits\HasUuid;

class Notification extends Model
{
    use HasUuid;

    protected $fillable = [
        'titulo',
        'mensagem',
        'nome_cliente',
        'telefone',
        'plano_id',
        'cliente_id',
        'lida',
    ];

    public function plano()
{
    return $this->belongsTo(
        Plano::class
    );
}
}
