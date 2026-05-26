@extends('adminlte::page')

@section('title', 'Detalhes do Cliente')

@section('content_header')
    <h1>Detalhes do Cliente</h1>
@stop

@section('content')
<div class="card">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h2 class="mb-1">

                    {{ $cliente->nome }}

                </h2>

                <p class="mb-0 text-muted">

                    Cliente desde
                    {{ $cliente->created_at->format('d/m/Y') }}

                </p>

            </div>

            <div>

                @if($cliente->status == 'ativo')

                    <span class="badge badge-success p-2">

                        Cliente Ativo

                    </span>

                @elseif($cliente->status == 'inativo')

                    <span class="badge badge-secondary p-2">

                        Cliente Inativo

                    </span>

                @else

                    <span class="badge badge-danger p-2">

                        Bloqueado

                    </span>

                @endif

            </div>

        </div>

        <hr>

        <div class="row">

            <div class="col-md-3 mb-3">

                <strong>Telefone</strong><br>

                {{ $cliente->telefone ?? '-' }}

            </div>

            <div class="col-md-3 mb-3">

                <strong>Email</strong><br>

                {{ $cliente->email ?? '-' }}

            </div>

            <div class="col-md-3 mb-3">

                <strong>CPF</strong><br>

                {{ $cliente->cpf ?? '-' }}

            </div>

            <div class="col-md-3 mb-3">

                <strong>RG</strong><br>

                {{ $cliente->rg ?? '-' }}

            </div>

            <div class="col-md-3 mb-3">

                <strong>Profissão</strong><br>

                {{ $cliente->profissao ?? '-' }}

            </div>

            <div class="col-md-3 mb-3">

                <strong>Estado Civil</strong><br>

                {{ $cliente->estado_civil ?? '-' }}

            </div>

            <div class="col-md-3 mb-3">

                <strong>Data Nascimento</strong><br>

                {{ $cliente->data_nascimento 
                    ? \Carbon\Carbon::parse($cliente->data_nascimento)->format('d/m/Y') 
                    : '-' }}

            </div>

            <div class="col-md-3 mb-3">

                <strong>Altura</strong><br>

                {{ $cliente->altura ?? '-' }}

            </div>

        </div>

        <hr>

        <h5 class="mb-3">

            Endereço

        </h5>

        <div class="row">

            <div class="col-md-4 mb-3">

                <strong>Rua</strong><br>

                {{ $cliente->endereco ?? '-' }}

            </div>

            <div class="col-md-2 mb-3">

                <strong>Número</strong><br>

                {{ $cliente->numero ?? '-' }}

            </div>

            <div class="col-md-3 mb-3">

                <strong>Bairro</strong><br>

                {{ $cliente->bairro ?? '-' }}

            </div>

            <div class="col-md-3 mb-3">

                <strong>Cidade</strong><br>

                {{ $cliente->cidade ?? '-' }}

            </div>

        </div>

        <hr>

        <div class="row">

            <div class="col-md-4">

                <div class="info-box">

                    <span class="info-box-icon bg-info">

                        <i class="fas fa-bicycle"></i>

                    </span>

                    <div class="info-box-content">

                        <span class="info-box-text">

                            Total de Locações

                        </span>

                        <span class="info-box-number">

                            {{ $cliente->locacoes->count() }}

                        </span>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="info-box">

                    <span class="info-box-icon bg-success">

                        <i class="fas fa-dollar-sign"></i>

                    </span>

                    <div class="info-box-content">

                        <span class="info-box-text">

                            Total Gerado

                        </span>

                        <span class="info-box-number">

                            R$
                            {{ number_format($cliente->locacoes->sum('valor_mensal'), 2, ',', '.') }}

                        </span>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="info-box">

                    <span class="info-box-icon bg-warning">

                        <i class="fas fa-clock"></i>

                    </span>

                    <div class="info-box-content">

                        <span class="info-box-text">

                            Locações Ativas

                        </span>

                        <span class="info-box-number">

                            {{ $cliente->locacoes->where('status', 'ativa')->count() }}

                        </span>

                    </div>

                </div>

            </div>

        </div>

        <hr>

        <div class="d-flex flex-wrap">

            <a href="https://wa.me/55{{ preg_replace('/[^0-9]/', '', $cliente->telefone) }}"
               target="_blank"
               class="btn btn-success mr-2 mb-2">

                <i class="fab fa-whatsapp"></i>

                WhatsApp

            </a>

            <a href="{{ route('clientes.edit', $cliente) }}"
               class="btn btn-warning mr-2 mb-2">

                <i class="fas fa-edit"></i>

                Editar

            </a>

            <a href="{{ route('clientes.locacao.create',$cliente) }}?cliente={{ $cliente->uuid }}"
               class="btn btn-primary mr-2 mb-2">

                <i class="fas fa-plus"></i>

                Nova Locação

            </a>

        </div>

    </div>

</div>


@php

$enderecoCompleto = urlencode(
    $cliente->endereco . ', ' .
    $cliente->bairro
    
);

@endphp

<div class="card">

    <div class="card-header">

        <h3 class="card-title">

            <i class="fas fa-map-marker-alt"></i>

            Localização do Cliente

        </h3>

    </div>

    <div class="card-body">

        <div class="mb-3">

            <a href="https://www.google.com/maps/search/?api=1&query={{ $enderecoCompleto }}"
               target="_blank"
               class="btn btn-danger">

                <i class="fas fa-map-marker-alt"></i>

                Abrir no Google Maps

            </a>

        </div>

        <iframe
            width="100%"
            height="350"
            style="border:0; border-radius:10px;"
            loading="lazy"
            allowfullscreen
            src="https://www.google.com/maps?q={{ $enderecoCompleto }}&output=embed">

        </iframe>

    </div>

</div>





<div class="card">

    <div class="card-header">

        <h3 class="card-title">

            Locações do Cliente

        </h3>

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>Bike</th>
                    <th>Plano</th>
                    <th>Início</th>
                    <th>Vencimento</th>
                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

                @foreach($cliente->locacoes as $locacao)

                <tr>

                    <td>

                        {{ $locacao->bike->modelo ?? '-' }}

                    </td>

                    <td>

                        {{ $locacao->plano->nome ?? '-' }}

                    </td>

                    <td>

                        {{ \Carbon\Carbon::parse($locacao->data_inicio)->format('d/m/Y') }}

                    </td>

                    <td>

                        {{ \Carbon\Carbon::parse($locacao->data_vencimento)->format('d/m/Y') }}

                    </td>

                    <td>

                        @if($locacao->status == 'ativa')

                            <span class="badge badge-success">
                                Ativa
                            </span>

                        @elseif($locacao->status == 'atrasada')

                            <span class="badge badge-danger">
                                Atrasada
                            </span>

                        @else

                            <span class="badge badge-secondary">
                                Finalizada
                            </span>

                        @endif

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>







@php
$totalPago = $cliente->pagamentos->where('usado', false)->sum('valor');
$valorPlano = $cliente->plano->valor ?? 0;
$falta = $valorPlano - $totalPago;
@endphp

<div class="alert alert-info">
    💰 Pago: R$ {{ $totalPago }} <br>
    📦 Plano: R$ {{ $valorPlano }} <br>
    ⚠️ Falta: R$ {{ max($falta, 0) }}
</div>
<div class="card mt-4">
    <div class="card-header">
        <strong>Registrar Pagamento</strong>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('pagamentos.store') }}">
            @csrf

            <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">

            <div class="row">

               <div class="col-md-3">
    <label>Valor</label>
    <input type="number" step="0.01" name="valor" class="form-control" required>
</div>

<div class="col-md-3">
    <label>Data do Pagamento</label>
    <input type="date" name="data_pagamento" class="form-control">
</div>

<div class="col-md-3">
    <label>Forma</label>
    <select name="forma_pagamento" class="form-control">
        <option>Pix</option>
        <option>Cartão</option>
        <option>Dinheiro</option>
    </select>
</div>

                <div class="col-md-3">
                    <label>Observação</label>
                    <input name="observacao" class="form-control">
                </div>

            </div>

            <button class="btn btn-success mt-3">
                Registrar Pagamento
            </button>

        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <strong>Histórico de Pagamentos</strong>
    </div>

    <div class="card-body">

        <table class="table">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Forma</th>
                    <th>Obs</th>
                    <th>Ação</th>
                </tr>
            </thead>

            <tbody>
                @foreach($cliente->pagamentos as $pagamento)
                <tr>
                    <td>{{ $pagamento->data_pagamento }}</td>
                    <td>R$ {{ $pagamento->valor }}</td>
                    <td>{{ $pagamento->forma_pagamento }}</td>
                    <td>{{ $pagamento->observacao }}</td>
                    <td>

    <!-- EDITAR -->
    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{ $pagamento->id }}">
        Editar
    </button>

    <!-- EXCLUIR -->
    <form action="{{ route('pagamentos.destroy', $pagamento->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger btn-sm">Excluir</button>
    </form>

</td>
                </tr>

                <div class="modal fade" id="edit{{ $pagamento->id }}">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('pagamentos.update', $pagamento->id) }}">
            @csrf
            @method('PUT')

            <div class="modal-content">

                <div class="modal-header">
                    <h5>Editar Pagamento</h5>
                </div>

                <div class="modal-body">

                    <label>Valor</label>
                    <input name="valor" value="{{ $pagamento->valor }}" class="form-control">

                    <label>Data</label>
                    <input type="date" name="data_pagamento"
                        value="{{ $pagamento->data_pagamento }}"
                        class="form-control">

                    <label>Forma</label>
                    <input name="forma_pagamento" value="{{ $pagamento->forma_pagamento }}" class="form-control">

                    <label>Observação</label>
                    <input name="observacao" value="{{ $pagamento->observacao }}" class="form-control">

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Salvar</button>
                </div>

            </div>
        </form>
    </div>
</div>
                @endforeach
            </tbody>

        </table>

    </div>
</div>
@stop