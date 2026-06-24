<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\HasUuid;

class Locacao extends Model
{
    use HasUuid;
    protected $table = 'locacoes';
    
    protected $fillable = [
        'bike_id',
        'cliente_id',
        'plano_id',
        'valor_mensal',
        'data_inicio',
        'data_vencimento',
        'status',
        'observacoes'
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_vencimento' => 'date',
    ];

   public function bike()
    {
        return $this->belongsTo(Bike::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function plano()
{
    return $this->belongsTo(Plano::class);
}
public function renovacoes()
{
    return $this->hasMany(LocacaoRenovacao::class);
}
public function pagamentos()
{
    return $this->hasMany(Pagamento::class);
}
protected static function booted()
{
    static::creating(function ($locacao) {

        if (!$locacao->uuid) {
            $locacao->uuid = Str::uuid();
        }

    });
}

public function getRouteKeyName()
{
    return 'uuid';
}
public function getStatusLabelAttribute()
{
    return match($this->status) {
        'ativa' => 'Ativa',
        'atrasada' => 'Atrasada',
        'aguardando_entrega' => 'Aguardando Entrega',
        'aguardando_retirada' => 'Aguardando Retirada',
        default => 'Finalizada'
    };
}
public function eventos()
{
    return $this->hasMany(LocacaoEvento::class);
}

}
