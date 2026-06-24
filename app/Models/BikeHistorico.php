<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BikeHistorico extends Model
{
    protected $fillable = [
        'bike_id',
        'evento',
        'descricao',
        'user_id',
    ];
}
