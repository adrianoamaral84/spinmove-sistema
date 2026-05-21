<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $fillable = [
        'bike_id',
        'valor',
        'cliente',
        'observacoes',
        'data_venda'
    ];

    protected $casts = [
        'data_venda' => 'datetime',
    ];

    public function bike()
    {
        return $this->belongsTo(Bike::class);
    }
}
