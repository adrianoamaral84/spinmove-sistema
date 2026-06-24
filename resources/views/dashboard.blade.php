@extends('adminlte::page')
@section('title', 'Dashboard')
@section('css')
<link rel="stylesheet" href="{{ asset('spinmove/css/spinmove.css') }}">
@stop
@section('content_header')
<div class="mb-4">
    <h1 class="mb-1">Dashboard</h1>

    <small class="text-muted">
        Visão geral da operação
    </small>
</div>
@stop
@section('content')




<div class="row">

    <div class="col-lg-3 mb-4">
        <div class="card shadow-sm border-0 dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">

                    <div class="dashboard-icon icon-orange">
                        🚴
                    </div>

                    <div class="text-right">
                        <h2 class="mb-1 font-weight-bold">
                            {{ $totalBikes }}
                        </h2>

                        <small class="text-muted">
                            Total de Bikes
                        </small>
                    </div>

                </div>
            </div>

            <div class="dashboard-line line-orange"></div>

        </div>
    </div>

    <div class="col-lg-3 mb-4">
        <div class="card shadow-sm border-0 dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">

                    <div class="dashboard-icon icon-green">
                        🔑
                    </div>

                    <div class="text-right">
                        <h2 class="mb-1 font-weight-bold">
                            {{ $bikesAlugadas }}
                        </h2>

                        <small class="text-muted">
                            Bikes Alugadas
                        </small>
                    </div>

                </div>
            </div>

            <div class="dashboard-line line-green"></div>

        </div>
    </div>

    <div class="col-lg-3 mb-4">
        <div class="card shadow-sm border-0 dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">

                    <div class="dashboard-icon icon-blue">
                        📦
                    </div>

                    <div class="text-right">
                        <h2 class="mb-1 font-weight-bold">
                            {{ $bikesDisponiveis }}
                        </h2>

                        <small class="text-muted">
                            Bikes Disponíveis
                        </small>
                    </div>

                </div>
            </div>

            <div class="dashboard-line line-blue"></div>

        </div>
    </div>

    <div class="col-lg-3 mb-4">
        <div class="card shadow-sm border-0 dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">

                    <div class="dashboard-icon icon-orange">
                        👥
                    </div>

                    <div class="text-right">
                        <h2 class="mb-1 font-weight-bold">
                            {{ $clientesAtivos }}
                        </h2>

                        <small class="text-muted">
                            Clientes
                        </small>
                    </div>

                </div>
            </div>

            <div class="dashboard-line line-orange"></div>

        </div>
    </div>

</div>

<div class="row">

    <div class="col-lg-3 mb-4">
        <div class="card shadow-sm border-0 dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">

                    <div class="dashboard-icon icon-green">
                        💰
                    </div>

                    <div class="text-right">
                        <h4 class="mb-1 font-weight-bold">
                            R$ {{ number_format($recebidoMes, 2, ',', '.') }}
                        </h4>

                        <small class="text-muted">
                            Recebido no mês
                        </small>
                    </div>

                </div>
            </div>

            <div class="dashboard-line line-green"></div>

        </div>
    </div>

    <div class="col-lg-3 mb-4">
        <div class="card shadow-sm border-0 dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">

                    <div class="dashboard-icon icon-red">
                        ⚠️
                    </div>

                    <div class="text-right">
                        <h4 class="mb-1 font-weight-bold">
                            R$ {{ number_format($cobrancasPendentes, 2, ',', '.') }}
                        </h4>

                        <small class="text-muted">
                            Pendências
                        </small>
                    </div>

                </div>
            </div>

            <div class="dashboard-line line-red"></div>

        </div>
    </div>

    <div class="col-lg-3 mb-4">
        <div class="card shadow-sm border-0 dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">

                    <div class="dashboard-icon icon-blue">
                        🔄
                    </div>

                    <div class="text-right">
                        <h2 class="mb-1 font-weight-bold">
                            {{ $renovacoesMes }}
                        </h2>

                        <small class="text-muted">
                            Renovações do mês
                        </small>
                    </div>

                </div>
            </div>

            <div class="dashboard-line line-blue"></div>

        </div>
    </div>

    <div class="col-lg-3 mb-4">
        <div class="card shadow-sm border-0 dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">

                    <div class="dashboard-icon icon-gray">
                        📉
                    </div>

                    <div class="text-right">
                        <h2 class="mb-1 font-weight-bold">
                            {{ $atrasados }}
                        </h2>

                        <small class="text-muted">
                            Inadimplentes
                        </small>
                    </div>

                </div>
            </div>

            <div class="dashboard-line line-gray"></div>

        </div>
    </div>

</div>




<div class="notification-card mb-4">

    @if(($topNotifications ?? collect())->count())

        @php
            $item = $topNotifications->first();
        @endphp

        <div class="d-flex align-items-center">

            <div class="notification-icon mr-4">
                🔔
            </div>

            <div class="flex-grow-1">

                <h5 class="mb-1 font-weight-bold">
                    Novo cadastro recebido
                </h5>

                <p class="text-muted mb-2">
                    {{ $item->nome_cliente }}
                </p>

                <small class="text-muted">
                    {{ $item->created_at->diffForHumans() }}
                </small>

            </div>

            <div>

                <a
                    href="{{ route('clientes.show', $item->cliente_id) }}"
                    class="btn btn-sm btn-outline-primary">

                    Abrir cadastro

                </a>

                <a
                    href="https://wa.me/55{{ preg_replace('/\D/','',$item->telefone) }}"
                    target="_blank"
                    class="btn btn-sm btn-success">

                    WhatsApp

                </a>

            </div>

        </div>

    @else

        <div class="d-flex align-items-center">

            <div class="notification-icon mr-4">
                🔔
            </div>

            <div>

                <h5 class="mb-1">
                    Sem notificações no momento
                </h5>

                <p class="text-muted mb-0">
                    Tudo tranquilo por aqui!
                </p>

            </div>

        </div>

    @endif

</div>

</div>








<div class="row mt-4">

    {{-- VENCENDO --}}

    <div class="col-md-6">

        <div class="card shadow-sm border-0">

            <div class="card-header border-0 bg-white">

                <h3 class="card-title font-weight-bold">

                    📅 Vencendo em 7 dias

                </h3>

            </div>

            <div class="card-body">

                @forelse($vencendo as $locacao)

                    <div class="mb-3 border-bottom pb-3">

                        <strong>
                            {{ $locacao->cliente->nome }}
                        </strong>

                        <br>

                        <small class="text-muted">
                            Vence em:
                            {{ date('d/m/Y', strtotime($locacao->data_vencimento)) }}
                        </small>

                    </div>

                @empty

                    <div class="text-center py-5">

                        <div style="font-size:50px">
                            📅
                        </div>

                        <p class="text-muted mt-3 mb-0">
                            Nenhuma locação vencendo.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>



    {{-- PENDÊNCIAS --}}

    <div class="col-md-6">

        <div class="card shadow-sm border-0">

            <div class="card-header border-0 bg-white">

                <h3 class="card-title font-weight-bold">

                    💰 Pendências Financeiras

                </h3>

            </div>

            <div class="card-body">

                @forelse($pendentes as $pendente)

                    <div class="mb-3 border-bottom pb-3">

                        <strong>
                            {{ $pendente['cliente'] }}
                        </strong>

                        <br>

                        <small class="text-muted">
                            Saldo:
                        </small>

                        <strong class="text-danger">

                            R$
                            {{ number_format($pendente['saldo'], 2, ',', '.') }}

                        </strong>

                    </div>

                @empty

                    <div class="text-center py-5">

                        <div style="font-size:50px">
                            🧾
                        </div>

                        <p class="text-muted mt-3 mb-0">
                            Nenhuma pendência.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

@stop