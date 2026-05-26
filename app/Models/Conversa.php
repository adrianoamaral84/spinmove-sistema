<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Conversa extends Model
{
        use HasUuid;
    protected $fillable = [
        'telefone',
        'nome',
        'status',
        'ultima_mensagem',
        'ultima_mensagem_em',
        'contexto',
        'lead_id'
    ];

    protected $casts = [
        'contexto' => 'array',
        'ultima_mensagem_em' => 'datetime',
    ];

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'conversa_id');
    }
    public function lead()
{
    return $this->belongsTo(Lead::class);
}
}