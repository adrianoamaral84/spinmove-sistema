<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Traits\HasUuid;


class Cliente extends Model
{
    use HasUuid;
    use SoftDeletes;
    protected $fillable = [

    'nome',
    'telefone',
    'cpf',
    'endereco',
    'bairro',
    'email',
    'profissao',
    'estado_civil',
    'altura',
    'origem',
    'plano_id',
    'data_vencimento',
    'ultimo_aviso_at',
    'status_cobranca',
    'respondeu',
    'status',
    'observacoes',
    'data_nascimento',
    'data_inicio_locacao',
];
protected $casts = [
    'data_vencimento' => 'date',
    'data_nascimento' => 'date',
    'data_inicio_locacao' => 'date',
];


public function plano()
{
    return $this->belongsTo(\App\Models\Plano::class);
}

public function pagamentos()
{
    return $this->hasMany(\App\Models\Pagamento::class);
}

public function getStatusCalculadoAttribute()
{
    if (!$this->data_vencimento) {
        return 'sem plano';
    }

    $hoje = Carbon::now();
    $vencimento = Carbon::parse($this->data_vencimento);

    if ($hoje->gt($vencimento)) {
        return 'atrasado';
    }

    if ($hoje->diffInDays($vencimento) <= 3) {
        return 'vencendo';
    }

    return 'ativo';
}

public function getStatusFinanceiroAttribute()
{
    if (!$this->data_vencimento) {
        return 'sem_vencimento';
    }

    $dias = now()->diffInDays($this->data_vencimento, false);

    // vencido
    if ($dias < 0) {

        if (abs($dias) >= 7) {
            return 'inadimplente';
        }

        return 'atrasada';
    }

    // vencendo
    if ($dias <= 3) {
        return 'vencendo';
    }

    return 'em_dia';
}

public function conversa()
    {
        return $this->belongsTo(Conversa::class, 'conversa_id');
    }


public function locacoes()
{
    return $this->hasMany(Locacao::class);
}

public function getTelefoneFormatadoAttribute()
{
    return preg_replace(
        "/(\d{2})(\d{5})(\d{4})/",
        '($1) $2-$3',
        $this->telefone
    );
}




}
