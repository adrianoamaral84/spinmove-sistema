@extends('adminlte::page')

@section('title', 'Clientes')
@section('css')
<link rel="stylesheet" href="{{ asset('spinmove/css/spinmove.css') }}">
@stop

@section('content_header')
<div class="mb-4">
    <h1 class="mb-1">Clientes</h1>

    <small class="text-muted">
        Gerencie todos os clientes da SpinMove
    </small>
</div>
@stop


@section('content')
<div class="row mb-4">

    <div class="col-md-2">
        <div class="card dashboard-card">
            <div class="card-body text-center">
                <div class="dashboard-icon mx-auto mb-2 icon-blue">
                    <i class="fas fa-users"></i>
                </div>

                <h3>{{ $totalClientes }}</h3>

                <small class="text-muted">
                    Total Clientes
                </small>
            </div>

            <div class="dashboard-line line-blue"></div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card dashboard-card">
            <div class="card-body text-center">
                <div class="dashboard-icon mx-auto mb-2 icon-green">
                    <i class="fas fa-user-check"></i>
                </div>

                <h3>{{ $clientesAtivos }}</h3>

                <small class="text-muted">
                    Clientes Ativos
                </small>
            </div>

            <div class="dashboard-line line-green"></div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card dashboard-card">
            <div class="card-body text-center">
                <div class="dashboard-icon mx-auto mb-2 icon-red">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>

                <h3>{{ $inadimplentes }}</h3>

                <small class="text-muted">
                    Inadimplentes
                </small>
            </div>

            <div class="dashboard-line line-red"></div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card dashboard-card">
            <div class="card-body text-center">
                <div class="dashboard-icon mx-auto mb-2 icon-orange">
                    <i class="fas fa-user-plus"></i>
                </div>

                <h3>{{ $novosMes }}</h3>

                <small class="text-muted">
                    Novos no mês
                </small>
            </div>

            <div class="dashboard-line line-orange"></div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card dashboard-card">
            <div class="card-body text-center">
                <div class="dashboard-icon mx-auto mb-2 icon-green">
                    <i class="fas fa-dollar-sign"></i>
                </div>

                <h3>
                    R$ {{ number_format($ticketMedio,2,',','.') }}
                </h3>

                <small class="text-muted">
                    Ticket Médio
                </small>
            </div>

            <div class="dashboard-line line-green"></div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card dashboard-card">
            <div class="card-body text-center">
                <div class="dashboard-icon mx-auto mb-2 icon-gray">
                    <i class="fas fa-list"></i>
                </div>

                <h3>{{ $clientes->total() }}</h3>

                <small class="text-muted">
                    Exibidos
                </small>
            </div>

            <div class="dashboard-line line-gray"></div>
        </div>
    </div>

</div>


<div class="row mb-3">

    <!-- BOTÃO ESQUERDA -->
    <div class="col-md-6">
        <a href="{{ route('clientes.create') }}" class="btn btn-success">
    <i class="fas fa-plus mr-1"></i>
    Novo Cliente
</a>
    </div>

    <!-- BUSCA DIREITA -->
    <div class="col-md-6 d-flex justify-content-end">
        
                <input
    type="text"
    id="busca"
    class="form-control"
    placeholder="🔍 Buscar por nome, telefone ou CPF..."
>

                

           
    </div>

</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


<div class="mb-3">

    <a href="{{ route('clientes.index') }}" class="btn btn-secondary btn-sm">Todos</a>

    <a href="{{ route('clientes.index', ['status' => 'ativo']) }}" class="btn btn-success btn-sm">
        Ativos
    </a>

    <a href="{{ route('clientes.index', ['status' => 'devendo']) }}" class="btn btn-warning btn-sm">
        Devendo
    </a>

    <a href="{{ route('clientes.index', ['status' => 'atrasado']) }}" class="btn btn-danger btn-sm">
        Atrasados
    </a>

</div>



<div class="card">
    <div class="card-body p-0">

        <table class="table table-hover mb-0">    
            <thead>
                <tr>

                    <th>Cliente</th>

                    <th style="text-align: center;">Telefone</th>

                    <th style="text-align: center;">Bairro</th>

                    <th style="text-align: center;">Cliente Desde</th>

                    <th style="text-align: center;">Locações</th>

                    <th style="text-align: center;">Total Gerado</th>

                    <th style="text-align: center;">Status</th>

                    <th style="text-align: center;" width="220">Ações</th>

                </tr>
            </thead>

            <tbody id="tabela-clientes">
                @include('clientes.partials.tabela')
            </tbody>


</table>
</div>
</div>


<div id="loading" style="display:none;" class="text-center">
    <div class="spinner-border text-primary"></div>
</div>



<div class="mt-3">
   
</div>
@stop
@section('js')
<script>

let timeout = null;

document.getElementById('busca').addEventListener('keyup', function () {

    clearTimeout(timeout);

    let busca = this.value;

    timeout = setTimeout(() => {

        // 🔥 MOSTRA LOADING
        document.getElementById('loading').style.display = 'block';

        fetch("{{ route('clientes.buscar') }}?busca=" + busca)
            .then(res => res.text())
            .then(html => {

                // 🔄 ATUALIZA TABELA
                document.getElementById('tabela-clientes').innerHTML = html;

                // ❌ ESCONDE LOADING
                document.getElementById('loading').style.display = 'none';

            });

    }, 300);

});

</script>
@stop