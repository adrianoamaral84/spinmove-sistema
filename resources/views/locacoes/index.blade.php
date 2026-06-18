@extends('adminlte::page')

@section('title', 'Locações')

@section('css')
<link rel="stylesheet" href="{{ asset('spinmove/css/spinmove.css') }}">
<link rel="stylesheet"
      href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">
@stop

@section('content')

{{-- =========================
    HEADER
========================= --}}
<div class="content-header section-block">
    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h3 class="mb-0">Locações</h3>
            <small class="text-muted">
                Gestão completa das locações SpinMove
            </small>
        </div>

        <a href="{{ route('locacoes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Nova Locação
        </a>

    </div>
</div>

{{-- =========================
    KPIs
========================= --}}
<div class="section-block">
    <div class="row">

        {{-- ATIVAS --}}
        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body text-center">

                    <div class="dashboard-icon mx-auto mb-2 icon-green">
                        <i class="fas fa-check"></i>
                    </div>

                    <h3>{{ $locacoesAtivas }}</h3>

                    <small class="dashboard-label">
                        Locações Ativas
                    </small>

                </div>
                <div class="dashboard-line line-green"></div>
            </div>
        </div>

        {{-- ATRASADAS --}}
        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body text-center">

                    <div class="dashboard-icon mx-auto mb-2 icon-red">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>

                    <h3>{{ $locacoesAtrasadas }}</h3>

                    <small class="dashboard-label">
                        Atrasadas
                    </small>

                </div>
                <div class="dashboard-line line-red"></div>
            </div>
        </div>

        {{-- VENCEM HOJE --}}
        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body text-center">

                    <div class="dashboard-icon mx-auto mb-2 icon-orange">
                        <i class="fas fa-calendar"></i>
                    </div>

                    <h3>{{ $vencemHoje }}</h3>

                    <small class="dashboard-label">
                        Vencem Hoje
                    </small>

                </div>
                <div class="dashboard-line line-orange"></div>
            </div>
        </div>

        {{-- RECEITA --}}
        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body text-center">

                    <div class="dashboard-icon mx-auto mb-2 icon-blue">
                        <i class="fas fa-dollar-sign"></i>
                    </div>

                    <h3>R$ {{ number_format($receitaMensal,2,',','.') }}</h3>

                    <small class="dashboard-label">
                        Receita Mensal
                    </small>

                </div>
                <div class="dashboard-line line-blue"></div>
            </div>
        </div>

    </div>
</div>

{{-- =========================
    ALERTA
========================= --}}
@if(session('success'))
<div class="section-block">
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
</div>
@endif

{{-- =========================
    FILTROS
========================= --}}
<div class="section-block">

    <div class="card">
        <div class="card-header">
            Filtros
        </div>

        <div class="card-body">
            <div class="row">

                <div class="col-md-6">
                    <input type="text"
                           id="filtroCliente"
                           class="form-control"
                           placeholder="Buscar cliente...">
                </div>

                <div class="col-md-6">
                    <select id="filtroStatus" class="form-control">
                        <option value="">Todos Status</option>
                        <option value="ativa">Ativa</option>
                        <option value="atrasada">Atrasada</option>
                        <option value="aguardando">Aguardando</option>
                        <option value="finalizada">Finalizada</option>
                    </select>
                </div>

            </div>
        </div>
    </div>

</div>

{{-- =========================
    TABELA
========================= --}}
<div class="section-block">

    <div class="card">

        <div class="table-wrapper">

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
                        <th width="180">Ações</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($locacoes as $locacao)

                @php
                    $venceHoje = $locacao->data_vencimento
                        ? \Carbon\Carbon::parse($locacao->data_vencimento)
                        : null;

                    $diasRestantes = $venceHoje
                        ? now()->diffInDays($venceHoje, false)
                        : null;

                    $cobrancas = $locacao->pagamentos->where('tipo','cobranca');

                    $totalPago = $locacao->pagamentos
                        ->where('tipo','pagamento')
                        ->sum('valor');

                    $saldoPendente = 0;

                    foreach ($cobrancas as $cobranca) {

                        $pagoDaCobranca = $locacao->pagamentos
                            ->where('tipo','pagamento')
                            ->where('cobranca_id',$cobranca->id)
                            ->sum('valor');

                        $saldo = $cobranca->valor - $pagoDaCobranca;

                        if ($saldo > 0) {
                            $saldoPendente += $saldo;
                        }
                    }
                @endphp

                <tr>

                    <td>
                        <strong>{{ $locacao->cliente->nome ?? '-' }}</strong>
                    </td>

                    <td>{{ $locacao->bike->modelo ?? '-' }}</td>

                    <td>
                        <span class="badge badge-primary">
                            {{ $locacao->plano->nome ?? 'Sem plano' }}
                        </span>
                    </td>

                    <td>
                        <strong class="text-success">
                            R$ {{ number_format($locacao->valor_mensal,2,',','.') }}
                        </strong>
                    </td>

                    <td>
                        {{ $locacao->data_inicio ? \Carbon\Carbon::parse($locacao->data_inicio)->format('d/m/Y') : '-' }}
                    </td>

                    <td>
                        {{ $venceHoje ? $venceHoje->format('d/m/Y') : '-' }}
                    </td>

                    <td>
                        @if($locacao->status == 'ativa')
                            <span class="badge badge-success">Ativa</span>
                        @elseif($locacao->status == 'atrasada')
                            <span class="badge badge-danger">Atrasada</span>
                        @else
                            <span class="badge badge-secondary">{{ $locacao->status }}</span>
                        @endif
                    </td>

                    <td>
                        @if($saldoPendente <= 0)
                            <span class="badge badge-success">Quitado</span>
                        @else
                            <span class="badge badge-warning">Pendente</span>
                        @endif

                        <br>
                        <small>R$ {{ number_format($saldoPendente,2,',','.') }}</small>
                    </td>

                    <td>
<div class="table-actions">
    
<a href="{{ route('locacoes.show', $locacao->uuid) }}"
                               class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('locacoes.edit', $locacao->uuid) }}"
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

			@if($locacao->status == 'aguardando_entrega')

			<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#entregaModal{{ $locacao->uuid }}" title="Entregar Bike">

    <i class="fas fa-check"></i>
</button>
@endif

 @if($locacao->status != 'aguardando_entrega')

    <form action="{{ route('locacoes.renovar', $locacao->uuid) }}"
          method="POST"
          
          style="display:inline-block">

        @csrf

        <button class="btn btn-primary btn-sm" title="Renovar Plano">

            <i class="fas fa-sync"></i>

        </button>

    </form>

@endif

 @if($locacao->status == 'aguardando_retirada')
  <form action="{{ route('locacoes.devolver', $locacao->uuid) }}"
          method="POST"
          
          style="display:inline-block">

        @csrf

        <button type="button" class="btn btn-danger btn-sm"
        data-toggle="modal"
        data-target="#devolverModal{{ $locacao->uuid }}" title="Retirar Bike">

    <i class="fas fa-undo"></i>

</button>

    </form>


@endif

<button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#historicoModal{{ $locacao->id }}" title="Historico Renovação">

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
     id="entregaModal{{ $locacao->uuid }}"
     tabindex="-1">

    <div class="modal-dialog">

        <form action="{{ route('locacoes.entregar', $locacao) }}"
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

@section('js')

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>

<script>
$(function () {
    $('.table').DataTable({
        pageLength: 25,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json'
        }
    });
});
</script>

@stop
