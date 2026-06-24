<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Traits\HasUuid;
use App\Models\ClienteHistorico;



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
    'numero',
    'cidade',
    'cep',
    'aceite_contrato',
    'aceite_detalhes',
    'estado',

    
];
protected $casts = [
    'data_vencimento' => 'date',
    'data_nascimento' => 'date',
    'data_inicio_locacao' => 'date',
     'aceite_detalhes' => 'array',
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
public function getCpfFormatadoAttribute()
{
    $cpf = preg_replace('/\D/', '', $this->cpf);

    if (strlen($cpf) != 11) {
        return $this->cpf;
    }

    return preg_replace(
        "/(\d{3})(\d{3})(\d{3})(\d{2})/",
        "$1.$2.$3-$4",
        $cpf
    );
}
public function historicos()
{
    return $this->hasMany(
        ClienteHistorico::class
    )->latest();
}



public function setNomeAttribute($value)
{
    $this->attributes['nome'] = $value
        ? Str::title(mb_strtolower(trim($value)))
        : null;
}

public function setCidadeAttribute($value)
{
    $this->attributes['cidade'] = $value
        ? Str::title(mb_strtolower(trim($value)))
        : null;
}

public function setEstadoAttribute($value)
{
    $this->attributes['estado'] = $value
        ? mb_strtoupper(trim($value))
        : null;
}

public function setEmailAttribute($value)
{
    $this->attributes['email'] = $value
        ? mb_strtolower(trim($value))
        : null;
}
public function setCpfAttribute($value)
{
    $this->attributes['cpf'] = $value
        ? preg_replace('/\D/', '', $value)
        : null;
}
public function setTelefoneAttribute($value)
{
    $this->attributes['telefone'] = $value
        ? preg_replace('/\D/', '', $value)
        : null;
}
public function setCepAttribute($value)
{
    $this->attributes['cep'] = $value
        ? preg_replace('/\D/', '', $value)
        : null;
}
public function setEnderecoAttribute($value)
{
    $this->attributes['endereco'] = $value
        ? Str::title(mb_strtolower(trim($value)))
        : null;
}
public function setBairroAttribute($value)
{
    $this->attributes['bairro'] = $value
        ? Str::title(mb_strtolower(trim($value)))
        : null;
}



}
