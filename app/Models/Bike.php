<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\HasUuid;

class Bike extends Model
{
    use HasUuid;
    protected $fillable = [

        'codigo',
        'modelo',
        'marca',
        'status',
        'observacoes',
        'ultima_manutencao',
        'status_patrimonial',
'data_venda',
'valor_venda',
 'valor_compra',
    'data_compra',

    ];

    protected $casts = [

        'ultima_manutencao' => 'date',

    ];

    public function vendas()
{
    return $this->hasMany(Venda::class);
}

public function locacoes()
{
    return $this->hasMany(Locacao::class);
}

public function historicos()
{
    return $this->hasMany(
        BikeHistorico::class
    )->latest();
}


public function setCodigoAttribute($value)
{
    $this->attributes['codigo'] = $value
        ? mb_strtoupper(trim($value))
        : null;
}

public function setMarcaAttribute($value)
{
    $this->attributes['marca'] = $value
        ? Str::title(mb_strtolower(trim($value)))
        : null;
}

public function setModeloAttribute($value)
{
    $this->attributes['modelo'] = $value
        ? Str::title(mb_strtolower(trim($value)))
        : null;
}
public function setStatusAttribute($value)
{
    $this->attributes['status'] = $value
        ? mb_strtolower(trim($value))
        : null;
}
}
