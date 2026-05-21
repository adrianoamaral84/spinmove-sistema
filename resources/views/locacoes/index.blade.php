@extends('adminlte::page')

@section('title', 'Locações')

@section('content_header')
    <h1>Locações</h1>
@stop

@section('content')
<div class="row mb-4">

    <div class="col-md-3">

        <div class="small-box bg-success">

            <div class="inner">
                <h3>{{ $locacoesAtivas }}</h3>
                <p>Locações Ativas</p>
            </div>

            <div class="icon">
                <i class="fas fa-check"></i>
            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="small-box bg-danger">

            <div class="inner">
                <h3>{{ $locacoesAtrasadas }}</h3>
                <p>Atrasadas</p>
            </div>

            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="small-box bg-warning">

            <div class="inner">
                <h3>{{ $vencemHoje }}</h3>
                <p>Vencem Hoje</p>
            </div>

            <div class="icon">
                <i class="fas fa-calendar"></i>
            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="small-box bg-info">

            <div class="inner">

                <h3>
                    R$ {{ number_format($receitaMensal, 2, ',', '.') }}
                </h3>

                <p>Receita Mensal</p>

            </div>

            <div class="icon">
                <i class="fas fa-dollar-sign"></i>
            </div>

        </div>

    </div>

</div>


<div class="mb-3">

    <a href="{{ route('locacoes.create') }}"
       class="btn btn-primary">

        <i class="fas fa-plus"></i>

        Nova Locação

    </a>

</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">

    <div class="card-body table-responsive">

        <table class="table table-hover table-bordered">

            <thead>

                <tr>

                    <th>Cliente</th>
                    <th>Bike</th>
                    <th>Plano</th>
                    <th>Valor</th>
                    <th>Início</th>
                    <th>Vencimento</th>
                    <th>Status</th>
                    <th>Financeiro</th>
                    <th>Ações</th>

                </tr>

            </thead>

            <tbody>

           @foreach($locacoes as $locacao)     

                <tr>

                    <td>
                        <a href="{{ route('clientes.show', $locacao->cliente->id) }}" class="btn btn-info btn-sm">
            {{ $locacao->cliente->nome ?? '-' }}
                </a>
                       
                    </td>

                    <td>
                        {{ $locacao->bike->modelo ?? '-' }}
                    </td>

                    <td>
                        <span class="badge bg-primary">{{ $locacao->plano->nome ?? 'Sem plano' }}</span>
 
                        
                    </td>

                    <td>

                        R$
                        {{ number_format($locacao->valor_mensal, 2, ',', '.') }}

                    </td>

                    <td>
@if($locacao->data_inicio)

{{ date(
'd/m/Y',
strtotime(
$locacao->data_inicio
)
) }}

@else

-

@endif
                    
                    </td>

                    <td>

                        @php

$venceHoje = null;

if($locacao->data_vencimento){

    $venceHoje = \Carbon\Carbon::parse(
        $locacao->data_vencimento
    );

}

@endphp


@if($locacao->data_vencimento)

    @if(
        $venceHoje->isPast()
        &&
        $locacao->status != 'finalizada'
    )

        <span class="text-danger font-weight-bold">

            {{ $venceHoje->format('d/m/Y') }}

        </span>

    @else

        {{ $venceHoje->format('d/m/Y') }}

    @endif

@else

    -

@endif


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

    @elseif($locacao->status == 'aguardando_entrega')

        <span class="badge badge-warning">
            Aguardando Entrega
        </span>

    @elseif($locacao->status == 'aguardando_retirada')

        <span class="badge badge-danger">
            Aguardando Reitada
        </span>

    @else

        <span class="badge badge-info">
            Finalizada
        </span>

    @endif

    <br>

    <span class="badge badge-info mt-1">

        {{ $locacao->renovacoes->count() }} renovações

    </span>

</td>
<td>

@php

$cobrancas = $locacao->pagamentos
    ->where('tipo', 'cobranca');

$totalPago = $locacao->pagamentos
    ->where('tipo', 'pagamento')
    ->sum('valor');

$saldoPendente = 0;


foreach ($cobrancas as $cobranca) {

    $pagoDaCobranca = $locacao->pagamentos
        ->where('tipo', 'pagamento')
        ->where('cobranca_id', $cobranca->id)
        ->sum('valor');

    $saldo =
        $cobranca->valor
        - $pagoDaCobranca;

    if ($saldo > 0) {

        $saldoPendente += $saldo;

    }

}

@endphp


@if($saldoPendente <= 0)

    <span class="badge badge-success">

        Quitado

    </span>

@elseif($totalPago > 0)

    <span class="badge badge-warning">

        Parcial

    </span>

@else

    <span class="badge badge-danger">

        Pendente

    </span>

@endif

<br>

<small>

    R$
    {{ number_format(
        $saldoPendente,
        2,
        ',',
        '.'
    ) }}

</small>
</td>
                    <td>

                        <div class="d-flex align-items-center">

    <a href="{{ route('locacoes.show', $locacao->id) }}"
       class="btn btn-info btn-sm mr-1" title="Ver">

        <i class="fas fa-eye"></i>

    </a>

    <a href=""
       class="btn btn-warning btn-sm mr-1" title="Editar">

        <i class="fas fa-edit"></i>

    </a>

    
    
    
    @if($locacao->status == 'aguardando_entrega')

<button class="btn btn-success btn-sm mr-1"
        data-toggle="modal"
        data-target="#entregaModal{{ $locacao->id }}" title="Entregar Bike">

    <i class="fas fa-check"></i>

</button>
@endif


    

    @if($locacao->status != 'aguardando_entrega')

    <form action="{{ route('locacoes.renovar', $locacao->id) }}"
          method="POST"
          class="mr-1"
          style="display:inline-block">

        @csrf

        <button class="btn btn-primary btn-sm" title="Renovar Plano">

            <i class="fas fa-sync"></i>

        </button>

    </form>

@endif


    @if($locacao->status == 'aguardando_retirada')
  <form action="{{ route('locacoes.devolver', $locacao->id) }}"
          method="POST"
          class="mr-1"
          style="display:inline-block">

        @csrf

        <button type="button" class="btn btn-danger btn-sm"
        data-toggle="modal"
        data-target="#devolverModal{{ $locacao->id }}" title="Retirar Bike">

    <i class="fas fa-undo"></i>

</button>

    </form>


@endif
<button class="btn btn-secondary btn-sm"
            data-toggle="modal"
            data-target="#historicoModal{{ $locacao->id }}" title="Historico Renovação">

        <i class="fas fa-history"></i>

    </button>
    

</div>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>


     
@foreach($locacoes as $locacao)

<div class="modal fade"
     id="pagamentoModal{{ $locacao->id }}"
     tabindex="-1">

    <div class="modal-dialog">

        <form action="{{ route('locacoes.pagamento', $locacao->id) }}"
              method="POST">

            @csrf

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Registrar Pagamento

                    </h5>

                    <button type="button"
                            class="close"
                            data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    <div class="form-group">

                        <label>Valor</label>

                        <input type="number"
                               step="0.01"
                               name="valor"
                               class="form-control"
                               value="{{ $locacao->valor_mensal }}"
                               required>

                    </div>

                    <div class="form-group">

                        <label>Forma Pagamento</label>

                        <select name="forma_pagamento"
                                class="form-control"
                                required>

                            <option value="pix">
                                PIX
                            </option>

                            <option value="cartao">
                                Cartão
                            </option>

                            <option value="dinheiro">
                                Dinheiro
                            </option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label>Parcelas</label>

                        <input type="number"
                               name="parcelas"
                               class="form-control"
                               value="1">

                    </div>

                    <div class="form-group">

                        <label>Observação</label>

                        <textarea name="observacao"
                                  class="form-control"></textarea>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">

                        Cancelar

                    </button>

                    <button class="btn btn-success">

                        Registrar

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>





<div class="modal fade"
     id="entregaModal{{ $locacao->id }}"
     tabindex="-1">

    <div class="modal-dialog">

        <form action="{{ route('locacoes.entregar', $locacao->id) }}"
              method="POST">

            @csrf

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Confirmar Entrega

                    </h5>

                    <button type="button"
                            class="close"
                            data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    <p>

                        Confirmar que a bike foi
                        entregue ao cliente?

                    </p>

                    <div class="alert alert-info">

                        <strong>Cliente:</strong>
                        {{ $locacao->cliente->nome ?? '-' }}

                        <br>

                        <strong>Bike:</strong>
                        {{ $locacao->bike->modelo ?? '-' }}

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">

                        Cancelar

                    </button>

                    <button class="btn btn-success">

                        Confirmar Entrega

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


{{-- MODAL DEVOLUÇÃO --}}
<div class="modal fade"
     id="devolverModal{{ $locacao->id }}"
     tabindex="-1">

    <div class="modal-dialog">

        <form action="{{ route('locacoes.devolver', $locacao->id) }}"
              method="POST">

            @csrf

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Finalizar Locação

                    </h5>

                    <button type="button"
                            class="close"
                            data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    <div class="form-group">

                        <label>Multa</label>

                        <input type="number"
                               step="0.01"
                               name="multa"
                               class="form-control">

                    </div>

                    <div class="form-group">

                        <label>Avarias</label>

                        <textarea name="avarias"
                                  class="form-control"></textarea>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">

                        Cancelar

                    </button>

                    <button class="btn btn-success">

                        Confirmar

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

{{-- MODAL HISTÓRICO --}}
<div class="modal fade"
     id="historicoModal{{ $locacao->id }}"
     tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    Histórico de Renovações

                </h5>

                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            <div class="modal-body">

                @if($locacao->renovacoes->count())

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>Data Anterior</th>
                            <th>Nova Data</th>
                            <th>Valor</th>
                            <th>Data Renovação</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($locacao->renovacoes as $renovacao)

                        <tr>

                            <td>

                                {{ \Carbon\Carbon::parse($renovacao->data_anterior)->format('d/m/Y') }}

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($renovacao->nova_data)->format('d/m/Y') }}

                            </td>

                            <td>

                                R$
                                {{ number_format($renovacao->valor, 2, ',', '.') }}

                            </td>

                            <td>

                                {{ $renovacao->created_at->format('d/m/Y H:i') }}

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

                @else

                    <p>Nenhuma renovação.</p>

                @endif

            </div>

        </div>

    </div>

</div>

@endforeach

    

</div>
    </div>

</div>

@stop