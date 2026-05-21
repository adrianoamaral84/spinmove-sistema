<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    //
    protected $fillable = ['nome', 'valor', 'duracao_dias'];

    public function clientes()
{
    return $this->hasMany(Cliente::class);
}
}
