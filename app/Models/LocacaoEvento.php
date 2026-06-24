<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocacaoEvento extends Model
{
    protected $table = 'locacao_eventos';
    protected $fillable = [
        'locacao_id',
        'tipo',
        'titulo',
        'descricao',
    ];

    public function locacao()
    {
        return $this->belongsTo(Locacao::class);
    }
}
