<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Lead extends Model
{
        use HasUuid;
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
