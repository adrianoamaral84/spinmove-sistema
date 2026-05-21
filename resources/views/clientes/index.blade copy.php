@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1>Clientes</h1>
@stop

@section('content')
<div class="row mb-4">

    <div class="col-md-2">

        <div class="small-box bg-success">

            <div class="inner">

                <h3>{{ $alugadas }}</h3>

                <p>Alugadas</p>

            </div>

            <div class="icon">
                <i class="fas fa-bicycle"></i>
            </div>

        </div>

    </div>

    <div class="col-md-2">

        <div class="small-box bg-warning">

            <div class="inner">

                <h3>{{ $aguardandoEntrega }}</h3>

                <p>Aguardando</p>

            </div>

            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>

        </div>

    </div>

    <div class="col-md-2">

        <div class="small-box bg-danger">

            <div class="inner">

                <h3>{{ $atrasadas }}</h3>

                <p>Atrasadas</p>

            </div>

            <div class="icon">
                <i class="fas fa-exclamation"></i>
            </div>

        </div>

    </div>

    <div class="col-md-2">

        <div class="small-box bg-dark">

            <div class="inner">

                <h3>{{ $inadimplentes }}</h3>

                <p>Inadimplentes</p>

            </div>

            <div class="icon">
                <i class="fas fa-ban"></i>
            </div>

        </div>

    </div>

    <div class="col-md-2">

        <div class="small-box bg-info">

            <div class="inner">

                <h3>R$ {{ number_format($faturamento, 2, ',', '.') }}</h3>

                <p>Faturamento</p>

            </div>

            <div class="icon">
                <i class="fas fa-dollar-sign"></i>
            </div>

        </div>

    </div>

</div>


<div class="row">

    {{-- ENTREGAS --}}
    <div class="col-md-6">

        <div class="card">

            <div class="card-header bg-warning">

                <h3 class="card-title">
                    Entregas Pendentes
                </h3>

            </div>

            <div class="card-body">

                @forelse($entregasPendentes as $cliente)

                    <p>
                        <strong>{{ $cliente->nome }}</strong>
                        <br>
                        {{ $cliente->telefone }}
                    </p>

                    <hr>

                @empty

                    <p>Nenhuma entrega pendente.</p>

                @endforelse

            </div>

        </div>

    </div>

    {{-- VENCIMENTOS --}}
    <div class="col-md-6">

        <div class="card">

            <div class="card-header bg-danger">

                <h3 class="card-title">
                    Vencimentos Hoje
                </h3>

            </div>

            <div class="card-body">

                @forelse($vencimentosHoje as $cliente)

                    <p>

                        <strong>{{ $cliente->nome }}</strong>

                        <br>

                        {{ $cliente->telefone }}

                    </p>

                    <hr>

                @empty

                    <p>Nenhum vencimento hoje.</p>

                @endforelse

            </div>

        </div>

    </div>

</div>



<div class="row mb-3">

    <!-- BOTÃO ESQUERDA -->
    <div class="col-md-6">
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
            + Novo Cliente
        </a>
    </div>

    <!-- BUSCA DIREITA -->
    <div class="col-md-6 d-flex justify-content-end">
        
                <input type="text" id="busca"
    class="form-control"
    placeholder="Buscar cliente...">

                

           
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

<table class="table table-hover table-bordered align-middle">    <thead>
        <tr>
            <th>Nome</th>
            <th>Telefone</th>
            <th style="text-align: center;">Plano</th>
            <th style="text-align: center;">Início</th>
<th style="text-align: center;">Vencimento</th>
            <th style="text-align: center;">Status</th>
            <th>Financeiro</th>
            
            <th style="text-align: center;">Ações</th>
        </tr>
    </thead>

    <tbody id="tabela-clientes">
        @include('clientes.partials.tabela')
    </tbody>
</table>

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