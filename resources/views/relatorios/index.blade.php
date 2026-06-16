@extends('adminlte::page')

@section('title', 'Relatórios')

@section('content')

<div class="mb-4">

    <h2 class="mb-1">
        Relatórios Gerenciais
    </h2>

    <p class="text-muted">
        Indicadores da operação SpinMove
    </p>

</div>

<div class="row">

    <div class="col-md-3">

        <div class="card dashboard-card">

            <div class="card-body">

                <small class="text-muted">
                    Clientes
                </small>

                <h2>
                    {{ $clientes }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card dashboard-card">

            <div class="card-body">

                <small class="text-muted">
                    Bikes
                </small>

                <h2>
                    {{ $bikes }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card dashboard-card">

            <div class="card-body">

                <small class="text-muted">
                    Locações Ativas
                </small>

                <h2>
                    {{ $locacoesAtivas }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card dashboard-card">

            <div class="card-body">

                <small class="text-muted">
                    Receita do Mês
                </small>

                <h2>
                    R$ {{ number_format($receitaMes,2,',','.') }}
                </h2>

            </div>

        </div>

    </div>

</div>

@stop