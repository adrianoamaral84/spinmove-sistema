@extends('adminlte::page')

@section('title', 'Detalhes do Cliente')

@section('css')
<link rel="stylesheet" href="{{ asset('spinmove/css/spinmove.css') }}">
@stop

@section('content_header')
<div class="mb-4">
    <h1 class="mb-1">Detalhes do Cliente</h1>

    <small class="text-muted">
        Informações completas do cliente
    </small>
</div>
@stop

@section('content')

@php

$enderecoCompleto = urlencode(
    ($cliente->endereco ?? '') . ', ' .
    ($cliente->numero ?? '') . ', ' .
    ($cliente->bairro ?? '') . ', ' .
    ($cliente->cidade ?? '') . ', ' .
    ($cliente->estado ?? '')
);

$totalPago = $cliente->pagamentos->where('usado', false)->sum('valor');
$valorPlano = $cliente->plano->valor ?? 0;
$falta = $valorPlano - $totalPago;

@endphp

<div class="card mb-4">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <div class="d-flex align-items-center">

                <div class="cliente-avatar mr-3" style="width:70px;height:70px;font-size:24px;">
                    {{ strtoupper(substr($cliente->nome,0,1)) }}
                </div>

                <div>

                    <h2 class="mb-1 font-weight">
                        {{ $cliente->nome }}
                    </h2>

                    <div class="text-muted">

                        Cliente desde
                        {{ $cliente->created_at->format('d/m/Y') }}

                    </div>

                </div>

            </div>

            <div>

                @if($cliente->status == 'ativo')

                    <span class="badge badge-success px-3 py-2">
                        Cliente Ativo
                    </span>

                @elseif($cliente->status == 'inativo')

                    <span class="badge badge-secondary px-3 py-2">
                        Cliente Inativo
                    </span>

                @else

                    <span class="badge badge-danger px-3 py-2">
                        Bloqueado
                    </span>

                @endif

            </div>

        </div>

        <hr>

        <div class="row">

            <div class="col-md-3 mb-4">
                <div class="cliente-label">Telefone</div>

                <div class="cliente-value">

                    <a href="https://wa.me/55{{ preg_replace('/[^0-9]/', '', $cliente->telefone) }}"
                       target="_blank">

                        {{ $cliente->telefone ?? '-' }}

                    </a>

                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="cliente-label">Email</div>
                <div class="cliente-value">{{ $cliente->email ?? '-' }}</div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="cliente-label">CPF</div>
                <div class="cliente-value">{{ $cliente->cpf_formatado }}</div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="cliente-label">RG</div>
                <div class="cliente-value">{{ $cliente->rg ?? '-' }}</div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="cliente-label">Profissão</div>
                <div class="cliente-value">{{ $cliente->profissao ?? '-' }}</div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="cliente-label">Estado Civil</div>
                <div class="cliente-value">{{ $cliente->estado_civil ?? '-' }}</div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="cliente-label">Nascimento</div>

                <div class="cliente-value">

                    {{ $cliente->data_nascimento
                        ? \Carbon\Carbon::parse($cliente->data_nascimento)->format('d/m/Y')
                        : '-' }}

                </div>

            </div>

            <div class="col-md-3 mb-4">
                <div class="cliente-label">Altura</div>
                <div class="cliente-value">{{ $cliente->altura ?? '-' }}</div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="cliente-label">Origem</div>
                <div class="cliente-value">{{ $cliente->origem ?? '-' }}</div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="cliente-label">Plano Atual</div>
                <div class="cliente-value">
                    {{ $cliente->plano->nome ?? '-' }}
                </div>
            </div>

        </div>

        <hr>

        <h5 class="cliente-section-title">
            Endereço
        </h5>

        <div class="row">

            <div class="col-md-4 mb-4">
                <div class="cliente-label">Rua</div>
                <div class="cliente-value">{{ $cliente->endereco ?? '-' }}</div>
            </div>

            <div class="col-md-2 mb-4">
                <div class="cliente-label">Número</div>
                <div class="cliente-value">{{ $cliente->numero ?? '-' }}</div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="cliente-label">Bairro</div>
                <div class="cliente-value">{{ $cliente->bairro ?? '-' }}</div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="cliente-label">Cidade</div>
                <div class="cliente-value">{{ $cliente->cidade ?? '-' }}</div>
            </div>

            <div class="col-md-2 mb-4">
                <div class="cliente-label">Estado</div>
                <div class="cliente-value">{{ $cliente->estado ?? '-' }}</div>
            </div>

            <div class="col-md-2 mb-4">
                <div class="cliente-label">CEP</div>
                <div class="cliente-value">{{ $cliente->cep ?? '-' }}</div>
            </div>

        </div>

                <hr>

        <div class="row">

            <div class="col-md-4 mb-3">

                <div class="card dashboard-card">

                    <div class="card-body text-center">

                        <div class="dashboard-icon icon-blue mx-auto mb-3">
                            <i class="fas fa-bicycle"></i>
                        </div>

                        <div class="dashboard-number">
                            {{ $cliente->locacoes->count() }}
                        </div>

                        <div class="dashboard-label">
                            Total de Locações
                        </div>

                    </div>

                    <div class="dashboard-line line-blue"></div>

                </div>

            </div>

            <div class="col-md-4 mb-3">

                <div class="card dashboard-card">

                    <div class="card-body text-center">

                        <div class="dashboard-icon icon-green mx-auto mb-3">
                            <i class="fas fa-dollar-sign"></i>
                        </div>

                        <div class="dashboard-number">
                            R$ {{ number_format($cliente->locacoes->sum('valor_mensal'),2,',','.') }}
                        </div>

                        <div class="dashboard-label">
                            Total Gerado
                        </div>

                    </div>

                    <div class="dashboard-line line-green"></div>

                </div>

            </div>

            <div class="col-md-4 mb-3">

                <div class="card dashboard-card">

                    <div class="card-body text-center">

                        <div class="dashboard-icon icon-orange mx-auto mb-3">
                            <i class="fas fa-clock"></i>
                        </div>

                        <div class="dashboard-number">
                            {{ $cliente->locacoes->where('status','ativa')->count() }}
                        </div>

                        <div class="dashboard-label">
                            Locações Ativas
                        </div>

                    </div>

                    <div class="dashboard-line line-orange"></div>

                </div>

            </div>

        </div>

        <hr>

        <div class="d-flex flex-wrap">

            <a href="https://wa.me/55{{ preg_replace('/[^0-9]/', '', $cliente->telefone) }}"
               target="_blank"
               class="btn btn-success mr-2 mb-2">

                <i class="fab fa-whatsapp mr-1"></i>
                WhatsApp

            </a>

            <a href="{{ route('clientes.edit', $cliente) }}"
               class="btn btn-warning mr-2 mb-2">

                <i class="fas fa-edit mr-1"></i>
                Editar

            </a>

            <a href="{{ route('clientes.locacao.create',$cliente) }}?cliente={{ $cliente->uuid }}"
               class="btn btn-primary mr-2 mb-2">

                <i class="fas fa-plus mr-1"></i>
                Nova Locação

            </a>

        </div>

    </div>

</div>

<!-- ALERTAS -->

<div class="card mb-4">

    <div class="card-header spinmove-header">

        <h5 class="mb-0">

            <i class="fas fa-bell mr-2"></i>

            Alertas do Cliente

        </h5>

    </div>

    <div class="card-body">

        @forelse($alertas as $alerta)

            @php

                $icone = match($alerta['tipo']) {

                    'danger' => 'fas fa-exclamation-circle',
                    'warning' => 'fas fa-exclamation-triangle',
                    'info' => 'fas fa-info-circle',
                    default => 'fas fa-check-circle'

                };

            @endphp

            <div class="d-flex align-items-center p-3 mb-3 border rounded bg-white">

                <div class="mr-3">

                    @if($alerta['tipo'] == 'danger')

                        <i class="{{ $icone }} text-danger fa-lg"></i>

                    @elseif($alerta['tipo'] == 'warning')

                        <i class="{{ $icone }} text-warning fa-lg"></i>

                    @elseif($alerta['tipo'] == 'info')

                        <i class="{{ $icone }} text-info fa-lg"></i>

                    @else

                        <i class="{{ $icone }} text-success fa-lg"></i>

                    @endif

                </div>

                <div>

                    {{ $alerta['texto'] }}

                </div>

            </div>

        @empty

            <div class="text-center py-4">

                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>

                <h5>Tudo certo!</h5>

                <p class="text-muted mb-0">

                    Nenhum alerta para este cliente.

                </p>

            </div>

        @endforelse

    </div>

</div>

<!-- MAPA -->

<div class="card card-outline card-secondary collapsed-card mb-4">

    <div class="card-header spinmove-header">

        <h5 class="mb-0 card-title">

            <i class="fas fa-map-marker-alt mr-2"></i>

            Localização do Cliente <small class="text-muted ml-2">
    {{ $cliente->bairro }}/{{ $cliente->cidade }}
</small>

        </h5>

        <div class="card-tools">

            <button type="button"
                    class="btn btn-tool"
                    data-card-widget="collapse">

                <i class="fas fa-plus"></i>

            </button>

        </div>

    </div>

    <div class="card-body">

        <a href="https://www.google.com/maps/search/?api=1&query={{ $enderecoCompleto }}"
           target="_blank"
           class="btn btn-danger mb-3">

            <i class="fas fa-map-marker-alt mr-1"></i>

            Abrir no Google Maps

        </a>

        <iframe
            width="100%"
            height="400"
            style="border:0;border-radius:14px;"
            loading="lazy"
            allowfullscreen
            src="https://www.google.com/maps?q={{ $enderecoCompleto }}&output=embed">
        </iframe>

    </div>

</div>

<!-- LOCAÇÕES -->


@php

$historico = collect();

foreach($cliente->locacoes as $locacao){

    $historico->push([
    'tipo' => 'Locação',
    'plano' => $locacao->plano->nome ?? '-',
    'inicio' => $locacao->data_inicio,
    'fim' => $locacao->data_vencimento,
    'status' => $locacao->status,
]);

    foreach($locacao->renovacoes as $renovacao){

        $historico->push([
    'tipo' => 'Renovação',
    'plano' => $renovacao->plano_nome ?? 'Não informado',
    'inicio' => $renovacao->data_anterior,
    'fim' => $renovacao->nova_data,
    'status' => 'renovada',
]);
    }

}
$historico = $historico->sortByDesc('fim');

@endphp
<div class="card card-outline card-secondary collapsed-card mt-4">

    <div class="card-header spinmove-header">

        <h3 class="card-title">
            <i class="fas fa-bicycle mr-2"></i>
        Locações e Renovações
        </h3>

        <div class="card-tools">

            <button type="button"
                    class="btn btn-tool"
                    data-card-widget="collapse">

                <i class="fas fa-plus"></i>

            </button>

        </div>

    </div>



    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table mb-0">

    <thead>
    <tr>
        <th>Tipo</th>
        <th>Plano</th>
        <th>Início</th>
        <th>Vencimento</th>
        <th>Status</th>
    </tr>
</thead>

<tbody>

    @forelse($historico as $item)

    <tr>

        <td>

            @if($item['tipo'] == 'Locação')

                <span class="badge badge-primary">
                    Locação
                </span>

            @else

                <span class="badge badge-info">
                    Renovação
                </span>

            @endif

        </td>
<td>
    {{ $item['plano'] }}
</td>
        <td>
            {{ \Carbon\Carbon::parse($item['inicio'])->format('d/m/Y') }}
        </td>

        <td>
            {{ \Carbon\Carbon::parse($item['fim'])->format('d/m/Y') }}
        </td>

        <td>
            {{ ucfirst($item['status']) }}
        </td>

    </tr>

    @empty

    <tr>
        <td colspan="4" class="text-center text-muted">
            Nenhum histórico encontrado.
        </td>
    </tr>

    @endforelse

</tbody>

</table>

        </div>

    </div>

</div>

<div class="card card-outline card-secondary collapsed-card mt-4">

    <div class="card-header spinmove-header">

        <h3 class="card-title">
            <i class="fas fa-history mr-2"></i>
            Histórico do Cliente
        </h3>

        <div class="card-tools">

            <button type="button"
                    class="btn btn-tool"
                    data-card-widget="collapse">

                <i class="fas fa-plus"></i>

            </button>

        </div>

    </div>

    <div class="card-body">

        @if($cliente->historicos->count())

            <div class="timeline">

                @foreach($cliente->historicos as $historico)

                    <div class="timeline-item">

                        <div class="timeline-icon">

                            @include(
                                'clientes.partials.historico-icon',
                                ['evento' => $historico->evento]
                            )

                        </div>

                        <div class="timeline-content">

                            <div class="d-flex justify-content-between align-items-center mb-2">

                                <strong>
                                    {{ $historico->evento }}
                                </strong>

                                <small class="text-muted">
                                    {{ $historico->created_at->format('d/m/Y H:i') }}
                                </small>

                            </div>

                            @if($historico->descricao)

                                <div>
                                    {{ $historico->descricao }}
                                </div>

                            @endif

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="text-center py-5">

                <i class="fas fa-history fa-3x text-muted mb-3"></i>

                <h5>Nenhum histórico registrado</h5>

                <p class="text-muted mb-0">
                    Ainda não existem movimentações cadastradas para este cliente.
                </p>

            </div>

        @endif

    </div>

</div>

<style>

.cliente-resumo-card{
    border:0;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 3px 15px rgba(0,0,0,.08);
    transition:.2s;
}

.cliente-resumo-card:hover{
    transform:translateY(-3px);
}


.cliente-section-title{
    font-size:18px;
    font-weight:700;
    color:#111827;
    margin-bottom:20px;
}

.dashboard-card{
    border:none;
    border-radius:14px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
}

.dashboard-icon{
    width:60px;
    height:60px;
    border-radius:50%;
    background:#f3f4f6;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
}

.dashboard-number{
    font-size:28px;
    font-weight:700;
    line-height:1.2;
}

.dashboard-label{
    color:#6b7280;
    font-size:14px;
}

.dashboard-line{
    height:4px;
}



.spinmove-header{
    background:#f8fafc;
    border-bottom:1px solid #e5e7eb;
    font-weight:600;
}

.timeline{
    position:relative;
    padding-left:35px;
}

.timeline:before{
    content:'';
    position:absolute;
    left:11px;
    top:0;
    width:2px;
    height:100%;
    background:#e5e7eb;
}

.timeline-item{
    position:relative;
    margin-bottom:25px;
}

.timeline-icon{
    position:absolute;
    left:-40px;
    top: 50%;
    width:34px;
    height:34px;
    background:#fff;
    border-radius:50%;
    text-align:center;
    line-height:24px;
    box-shadow:0 0 0 4px #fff;
    top: 50%;
    transform: translateY(-50%);
}

.timeline-content{
    background:#f8fafc;
    border-radius:12px;
    padding:15px;
    border:1px solid #e5e7eb;
}

.badge{
    font-size:12px;
    padding:8px 12px;
}

.table thead th{
    border-top:none;
    background:#f8fafc;
    font-weight:600;
}

.card{
    border:none;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 2px 12px rgba(0,0,0,.06);
}

iframe{
    box-shadow:0 2px 12px rgba(0,0,0,.08);
}

@media (max-width:768px){

    .dashboard-number{
        font-size:22px;
    }

    .cliente-value{
        margin-bottom:15px;
    }

}

</style>

@stop