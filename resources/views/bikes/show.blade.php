@extends('adminlte::page')

@section('title', 'Bike')
@section('css')
<link rel="stylesheet" href="{{ asset('spinmove/css/spinmove.css') }}">
@stop
@section('content')

<div class="content-header section-block">
    <h3 class="mb-0">Bike {{ $bike->modelo }}</h3>
    <small class="text-muted">
        Visão completa de performance e histórico
    </small>
</div>

{{-- =========================
    KPIs PRINCIPAIS
========================= --}}
<div class="section-block">
    <div class="row">

        {{-- RECEITA --}}
        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body text-center">

                    <div class="dashboard-icon mx-auto mb-2 icon-green">
                        <i class="fas fa-dollar-sign"></i>
                    </div>

                    <h3>R$ {{ number_format($totalReceita,2,',','.') }}</h3>

                    <small class="dashboard-label">
                        Receita Gerada
                    </small>

                </div>

                <div class="dashboard-line line-green"></div>
            </div>
        </div>

        {{-- LOCAÇÕES --}}
        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body text-center">

                    <div class="dashboard-icon mx-auto mb-2 icon-blue">
                        <i class="fas fa-sync"></i>
                    </div>

                    <h3>{{ $totalLocacoes }}</h3>

                    <small class="dashboard-label">
                        Total de Locações
                    </small>

                </div>

                <div class="dashboard-line line-blue"></div>
            </div>
        </div>

        {{-- ÚLTIMA LOCAÇÃO --}}
        <div class="col-md-3">
    @if($ultimaLocacao)

        <div class="card dashboard-card">
            <div class="card-body text-center">

                <div class="dashboard-icon mx-auto mb-2 icon-orange">
                    <i class="fas fa-calendar"></i>
                </div>

                <h3>
                    {{ \Carbon\Carbon::parse($ultimaLocacao->data_inicio)->format('d/m/Y') }}
                </h3>

                <small class="dashboard-label">
                    Última Locação
                </small>

            </div>

            <div class="dashboard-line line-orange"></div>
        </div>

    @else

        {{-- CARD VAZIO PARA MANTER GRID --}}
        <div class="card dashboard-card opacity-0">
            <div class="card-body text-center">
                <div class="dashboard-icon mx-auto mb-2">
                    <i class="fas fa-calendar"></i>
                </div>
                <h3>—</h3>
                <small class="dashboard-label">Última Locação</small>
            </div>
            <div class="dashboard-line line-orange"></div>
        </div>

    @endif
</div>

        {{-- RETORNO --}}
        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body text-center">

                    <div class="dashboard-icon mx-auto mb-2 icon-{{ $retorno >= 0 ? 'green' : 'red' }}">
                        <i class="fas fa-chart-line"></i>
                    </div>

                    <h3>
                        R$ {{ number_format($retorno,2,',','.') }}
                    </h3>

                    <small class="dashboard-label">
                        Retorno
                    </small>

                </div>

                <div class="dashboard-line line-{{ $retorno >= 0 ? 'green' : 'red' }}"></div>
            </div>
        </div>

    </div>
</div>

{{-- =========================
    INFO DA BIKE
========================= --}}
<div class="section-block">

    <div class="card">

        <div class="card-header">
            Informações da Bike
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-3">
                    <div class="cliente-label">Status</div>

                    @if($bike->status == 'disponivel')
                        <span class="badge badge-success">Disponível</span>
                    @elseif($bike->status == 'alugada')
                        <span class="badge badge-primary">Alugada</span>
                    @elseif($bike->status == 'manutencao')
                        <span class="badge badge-warning">Manutenção</span>
                    @elseif($bike->status == 'vendida')
                        <span class="badge badge-danger">Vendida</span>
                    @else
                        <span class="badge badge-secondary">{{ $bike->status }}</span>
                    @endif
                </div>

                <div class="col-md-3">
                    <div class="cliente-label">Valor Compra</div>
                    <div class="cliente-value">
                        R$ {{ number_format($bike->valor_compra,2,',','.') }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="cliente-label">Valor Venda</div>
                    <div class="cliente-value">
                        R$ {{ number_format($bike->valor_venda,2,',','.') }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="cliente-label">Cliente Atual</div>
                    <div class="cliente-value">
                        {{ $clienteAtual->cliente->nome ?? 'Disponível' }}

                        @if($clienteAtual)
                            <br>
                            <small class="text-muted">
                                Há {{ $diasLocada }} dias
                            </small>
                        @endif
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

{{-- =========================
    HISTÓRICO
========================= --}}
<div class="section-block">

    <div class="card">

        <div class="card-header">
            Histórico de Locações
        </div>

        <div class="table-wrapper">

            <table class="table table-hover">

                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Plano</th>
                        <th>Início</th>
                        <th>Vencimento</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($locacoes as $locacao)

                        <tr>
                            <td>{{ $locacao->cliente->nome ?? '-' }}</td>
                            <td>{{ $locacao->plano->nome ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($locacao->created_at)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($locacao->data_vencimento)->format('d/m/Y') }}</td>
                            <td>

                                @if($locacao->status == 'ativa')
                                    <span class="badge badge-success">Ativa</span>
                                @elseif($locacao->status == 'aguardando_retirada')
                                    <span class="badge badge-warning">Aguardando Retirada</span>
                                @else
                                    <span class="badge badge-secondary">Finalizada</span>
                                @endif

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-muted text-center">
                                Nenhuma locação registrada.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- =========================
    PERFORMANCE
========================= --}}
<div class="section-block">

    <div class="card">

        <div class="card-header">
            Performance da Bike
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-3">
                    <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Receita</span>
                            <span class="info-box-number">
                                R$ {{ number_format($totalReceita,2,',','.') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-shopping-cart"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Investimento</span>
                            <span class="info-box-number">
                                R$ {{ number_format($bike->valor_compra,2,',','.') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-box {{ $lucroLiquido >= 0 ? 'bg-success' : 'bg-danger' }}">
                        <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Retorno Líquido</span>
                            <span class="info-box-number">
                                R$ {{ number_format($lucroLiquido,2,',','.') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-box {{ $roi >= 100 ? 'bg-success' : ($roi >= 0 ? 'bg-warning' : 'bg-danger') }}">
                        <span class="info-box-icon"><i class="fas fa-percentage"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">ROI</span>
                            <span class="info-box-number">
                                {{ number_format($roi,0,',','.') }}%
                            </span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

@stop