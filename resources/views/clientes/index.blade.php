@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1>Clientes</h1>
@stop

@section('content')
<div class="row mb-4">

<div class="col-md-2">

<div class="small-box bg-info">

<div class="inner">

<h3>

{{ $totalClientes }}

</h3>

<p>

Total Clientes

</p>

</div>

</div>

</div>



<div class="col-md-2">

<div class="small-box bg-success">

<div class="inner">

<h3>

{{ $clientesAtivos }}

</h3>

<p>

Clientes Ativos

</p>

</div>

</div>

</div>



<div class="col-md-2">

<div class="small-box bg-danger">

<div class="inner">

<h3>

{{ $inadimplentes }}

</h3>

<p>

Inadimplentes

</p>

</div>

</div>

</div>



<div class="col-md-2">

<div class="small-box bg-warning">

<div class="inner">

<h3>

{{ $novosMes }}

</h3>

<p>

Novos no mês

</p>

</div>

</div>

</div>



<div class="col-md-2">

<div class="small-box bg-primary">

<div class="inner">

<h3>

R$

{{ number_format(
$ticketMedio,
2,
',',
'.'
) }}

</h3>

<p>

Ticket Médio

</p>

</div>

</div>

</div>



<div class="col-md-2">

<div class="small-box bg-secondary">

<div class="inner">

<h3>

{{ $clientes
->total()
}}

</h3>

<p>

Exibidos

</p>

</div>

</div>

</div>

</div><div class="col-md-12">

<div class="card">

<div class="card-header bg-success">

<h3 class="card-title">

Novos Clientes (7 dias)

</h3>

</div>

<div class="card-body p-2">

<div class="row">

@forelse($novos7Dias as $cliente)

<div class="col-md-6 mb-2">

<div
class="border rounded p-2"
>

<strong>

{{ $cliente->nome }}

</strong>

<br>

<small>

{{ $cliente->telefone }}

</small>

<br>

<small class="text-muted">

{{ $cliente->created_at->format('d/m/Y') }}

</small>

</div>

</div>

@empty

<div class="col-12">

Nenhum cliente novo.

</div>

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





<table class="table table-hover table-bordered">    
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