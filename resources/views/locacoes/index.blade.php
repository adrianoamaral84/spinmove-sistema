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
    <div class="card shadow-sm border-0">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table id="tabelaLocacoes"
                       class="table table-hover table-bordered mb-0">
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
                        <th width="10">Ações</th>
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

                    
                        <td style="width:250px">
    <a href="{{ route('locacoes.show', $locacao->uuid) }}"
       class="cliente-link nome-cliente cliente-link"
       title="{{ $locacao->cliente->nome ?? '-' }}">
        {{ $locacao->cliente->nome ?? '-' }}
    </a>

                       
                    </td>

                    <td class="text-center">{{ $locacao->bike->modelo ?? '-' }}</td>

                    <td class="text-center">
                        <span class="badge badge-primary">
                            {{ $locacao->plano->nome ?? 'Sem plano' }}
                        </span>
                    </td>

                    <td class="text-center">
                        <strong class="text-success">
                            R$ {{ number_format($locacao->valor_mensal,2,',','.') }}
                        </strong>
                    </td>

                    <td class="text-center">
                        {{ $locacao->data_inicio ? \Carbon\Carbon::parse($locacao->data_inicio)->format('d/m/Y') : '-' }}
                    </td>

                    <td class="text-center">
                        {{ $venceHoje ? $venceHoje->format('d/m/Y') : '-' }}
                    </td>

                    <td class="text-center">
                        @if($locacao->status == 'ativa')
                            <span class="badge badge-success">Ativa</span>
                        @elseif($locacao->status == 'atrasada')
                            <span class="badge badge-danger">Atrasada</span>
                        @else
                            <span class="badge badge-secondary">{{ $locacao->status }}</span>
                        @endif
                    </td>

                    <td class="text-center">
                        @if($saldoPendente <= 0)
                            <span class="badge badge-success">Quitado</span>
                        @else
                            <span class="badge badge-warning">Pendente</span>
                        @endif

                        <br>
                        <small>R$ {{ number_format($saldoPendente,2,',','.') }}</small>
                    </td>

                    <td class="text-center">

    <div class="dropdown">

        <button class="btn btn-sm btn-light border shadow-sm"
                type="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">

            <i class="fas fa-ellipsis-v"></i>

        </button>

        <div class="dropdown-menu dropdown-menu-right">

            <a class="dropdown-item"
               href="{{ route('locacoes.show', $locacao->uuid) }}">

                <i class="fas fa-eye text-info mr-2"></i>
                Visualizar

            </a>

            <a class="dropdown-item"
               href="{{ route('locacoes.edit', $locacao->uuid) }}">

                <i class="fas fa-edit text-warning mr-2"></i>
                Editar

            </a>

            @if($locacao->status == 'aguardando_entrega')

                <button type="button"
                        class="dropdown-item"
                        data-toggle="modal"
                        data-target="#entregaModal{{ $locacao->uuid }}">

                    <i class="fas fa-check text-success mr-2"></i>
                    Entregar Bike

                </button>

            @endif

            @if($locacao->status != 'aguardando_entrega')

               <button type="button"
            class="dropdown-item"
            data-toggle="modal"
            data-target="#renovarModal{{ $locacao->uuid }}">

        <i class="fas fa-sync text-primary mr-2"></i>
        Renovar Plano

    </button>

            @endif

            @if($locacao->status == 'aguardando_retirada')

                <button type="button"
                        class="dropdown-item"
                        data-toggle="modal"
                        data-target="#devolverModal{{ $locacao->uuid }}">

                    <i class="fas fa-undo text-danger mr-2"></i>
                    Retirar Bike

                </button>

            @endif
@if($locacao->status == 'aguardando_entrega ' || $locacao->status == 'ativa')
            <button type="button"
        class="dropdown-item"
        data-toggle="modal"
        data-target="#modalTrocarBike{{ $locacao->uuid }}">
    <i class="fas fa-bicycle mr-2"></i>
    Trocar Bike
</button>
 @endif
<div class="dropdown-divider"></div>

            <button type="button"
                    class="dropdown-item"
                    data-toggle="modal"
                    data-target="#historicoModal{{ $locacao->id }}">

                <i class="fas fa-history text-secondary mr-2"></i>
                Histórico de Renovações

            </button>

        </div>

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


<div class="modal fade" id="modalTrocarBike{{ $locacao->uuid }}" tabindex="-1" >

    <div class="modal-dialog">

        <div class="modal-content">


            <div class="modal-header spinmove-header">

                <h5 class="modal-title">
                    <i class="fas fa-bicycle mr-2"></i>
                    Trocar Bike
                </h5>

                <button type="button" 
                        class="close" 
                        data-dismiss="modal">
                    &times;
                </button>

            </div>


            <form action="{{ route('locacoes.trocarBike', $locacao->id) }}"
                  method="POST">

                @csrf


                <div class="modal-body">


                    <div class="form-group">

                        <label>
                            Bike atual
                        </label>

                        <input type="text"
                               class="form-control"
                               value="{{ $locacao->bike->codigo ?? 'Sem bike' }} - {{ $locacao->bike->marca ?? 'Sem bike' }}"
                               disabled>

                    </div>



                    <div class="form-group">

                        <label>
                            Nova bike
                        </label>


                        <select name="bike_id"
        class="form-control text-dark"
        style="color:#333 !important;"
        required>


                            <option value="">
                                Selecione uma bike
                            </option>

@foreach($bikesDisponiveis as $bike)

    <option value="{{ $bike->id }}"
            style="color:#333 !important;">

        {{ $bike->codigo }} - {{ $bike->marca }}

    </option>

@endforeach


                        </select>

                    </div>


                </div>



                <div class="modal-footer">


                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">

                        Cancelar

                    </button>


                    <button type="submit"
                            class="btn btn-warning">

                        Confirmar troca

                    </button>


                </div>


            </form>


        </div>

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





@php

$planoAtual = $locacao->plano;

$novaData =
\Carbon\Carbon::parse(
    $locacao->data_vencimento
)->addDays(
    $planoAtual->duracao_dias
);

@endphp
<div class="modal fade"
     id="renovarModal{{ $locacao->uuid }}"
     tabindex="-1">

    <div class="modal-dialog">

        <form action="{{ route('locacoes.renovar', $locacao->uuid) }}"
              method="POST">

            @csrf

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Renovar Locação

                    </h5>

                    <button type="button"
                            class="close"
                            data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    <div class="form-group">

                        <label>Plano</label>
<select name="plano_id"
        class="form-control plano-select" required>

                            @foreach($planos as $plano)

                            <option value="{{ $plano->id }}"
        data-dias="{{ $plano->duracao_dias }}"
        {{ $locacao->plano_id == $plano->id ? 'selected' : '' }}>

    {{ $plano->nome }}
    -
    R$ {{ number_format($plano->valor, 2, ',', '.') }}

</option>

                            @endforeach

                        </select>

                    </div>

                    <div class="form-group">

                        <label>Novo vencimento</label>
                        <input type="date"
       name="data_vencimento"
       class="form-control data-vencimento"
       data-vencimento-original="{{ $locacao->data_vencimento }}"
       value="{{ $novaData->format('Y-m-d') }}"
       required>

                    </div>

                    <div class="form-group">

                        <label>Observações</label>

                        <textarea name="observacoes"
                                  class="form-control"></textarea>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">

                        Cancelar

                    </button>

                    <button class="btn btn-primary">

                        Confirmar Renovação

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>
@endforeach


        </div>

    </div>

</div>
<style>
.table-wrapper{
    padding: 15px;
}

.dataTables_wrapper .row:first-child{
    margin-bottom: 15px;
    align-items: center;
}

.dataTables_length,
.dataTables_filter{
    margin-bottom: 10px;
}

.dataTables_filter{
    text-align:right;
}

.dataTables_filter input{
    border-radius:10px;
    border:1px solid #dee2e6;
    padding:6px 10px;
    height:38px;
}

.dataTables_length select{
    border-radius:10px;
    border:1px solid #dee2e6;
    height:38px;
}

.table{
    margin-bottom:0 !important;
}

.table thead th{
    vertical-align:middle !important;
    padding:14px 12px !important;
    font-size:12px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.5px;
    white-space:nowrap;
}

.table tbody td{
    padding:12px !important;
    vertical-align:middle !important;
}

.dataTables_paginate{
    margin-top:15px !important;
}

.dataTables_info{
    margin-top:20px !important;
}

.card{
    border-radius:12px;
    
}
.table thead th{
    text-align:center !important;
    vertical-align:middle !important;
}
.table thead th{
    text-align:center !important;
    vertical-align:middle !important;
}

.table tbody td:first-child{
    text-align:left !important;
}
.dataTables_wrapper{
    padding:10px;
}

  
.nome-cliente{
    display:block;
    max-width:250px;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
    font-weight:600;
}

.cliente-link{
    color:#212529 !important;
    text-decoration:none;
    font-weight:600;
}

.cliente-link:hover{
    color:#ff6b00 !important;
}

</style>
@stop

@section('js')

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>

<script>
$(function () {
    $('#tabelaLocacoes').DataTable({
    responsive: true,
    autoWidth: false,
    pageLength: 25,
    language: {
        url: '//cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json'
    },
    dom:
        "<'row mb-3'<'col-md-6'l><'col-md-6'f>>" +
        "rt" +
        "<'row mt-3'<'col-md-6'i><'col-md-6'p>>"
});
});
</script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const selects =
        document.querySelectorAll('.plano-select');

    selects.forEach(function(select){

        select.addEventListener('change', function(){

            const option =
                this.options[this.selectedIndex];

            const dias =
                parseInt(option.dataset.dias);

            const modal =
                this.closest('.modal');

            const inputData =
                modal.querySelector('.data-vencimento');

            // pega vencimento ORIGINAL
            const dataOriginal =
                inputData.dataset.vencimentoOriginal;

            const vencimento =
                new Date(dataOriginal);

            // soma dias do plano
            vencimento.setDate(
                vencimento.getDate() + dias
            );

            const ano =
                vencimento.getFullYear();

            const mes =
                String(vencimento.getMonth() + 1)
                .padStart(2, '0');

            const dia =
                String(vencimento.getDate())
                .padStart(2, '0');

            inputData.value =
                `${ano}-${mes}-${dia}`;

        });

    });

});

</script>
@stop
