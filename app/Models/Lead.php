<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
   protected $fillable = [
        'telefone',
        'nome',
        'status_lead',
        'ultima_mensagem',
        'origem'
    ];
    public function conversa()
{
    return $this->hasOne(Conversa::class);
}
}
