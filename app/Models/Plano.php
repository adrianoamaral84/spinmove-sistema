<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Plano extends Model
{
    //
        use HasUuid;
    protected $fillable = ['nome', 'valor', 'duracao_dias'];

    public function clientes()
{
    return $this->hasMany(Cliente::class);
}
public function getValorMensalAttribute()
{
    return $this->duracao_dias > 0
        ? ($this->valor / $this->duracao_dias) * 30
        : 0;
}

public function setNomeAttribute($value)
{
    $this->attributes['nome'] =
        Str::title(mb_strtolower(trim($value)));
}
}
