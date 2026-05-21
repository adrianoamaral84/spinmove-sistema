<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bike extends Model
{
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



}
