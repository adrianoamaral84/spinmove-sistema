<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteHistorico extends Model
{
    protected $fillable = [
        'cliente_id',
        'evento',
        'descricao',
        'user_id',
    ];
}
