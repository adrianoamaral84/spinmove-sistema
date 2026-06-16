@php
    use App\Models\Pagamento;
@endphp

@extends('adminlte::page')

@section('title', 'Detalhes da Locação')
@section('css')
<link rel="stylesheet" href="{{ asset('spinmove/css/spinmove.css') }}">
@stop
@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="mb-0">Detalhes da Locação</h1>
        <small class="text-muted">Informações completas da locação</small>
    </div>

    <a href="{{ route('locacoes.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>
@stop

@section('content')

{{-- =========================
    KPIS (PADRÃO CLIENTES)
========================= --}}
<div class="row mb-4">

    <div class="col-md-3">
        <div class="card dashboard-card">
            <div class="card-body text-center">
                <div class="dashboard-icon mx-auto mb-2 icon-blue">
                    <i class="fas fa-user"></i>
                </div>
                <h5>{{ $locacao->cliente->nome }}</h5>
                <small class="text-muted">Cliente</small>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card dashboard-card">
            <div class="card-body text-center">
                <div class="dashboard-icon mx-auto mb-2 icon-orange">
                    <i class="fas fa-bicycle"></i>
                </div>
                <h3>{{ $locacao->bike->modelo }}</h3>
                <small class="text-muted">Bike</small>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card dashboard-card">
            <div class="card-body text-center">
                <div class="dashboard-icon mx-auto mb-2 icon-green">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <h3>R$ {{ number_format($locacao->valor_mensal,2,',','.') }}</h3>
                <small class="text-muted">Valor Mensal</small>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card dashboard-card">
            <div class="card-body text-center">

                <div class="dashboard-icon mx-auto mb-2 icon-red">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>

                @php
                    $dias = now()->startOfDay()->diffInDays(
                        \Carbon\Carbon::parse($locacao->data_vencimento)->startOfDay(),
                        false
                    );
                @endphp

                <h3>
                    @if($dias < 0)
                        {{ abs($dias) }} dias
                    @else
                        {{ $dias }} dias
                    @endif
                </h3>

                <small class="text-muted">
                    {{ $dias < 0 ? 'Atrasado' : 'Restantes' }}
                </small>

            </div>
        </div>
    </div>

</div>

{{-- =========================
    INFO + STATUS
========================= --}}
<div class="row">

    {{-- COLUNA ESQUERDA --}}
    <div class="col-md-8">

        <div class="card mb-4">

    <div class="card-body">

        <div class="section-block">
            <h5>Informações da Locação</h5>

            <small class="text-muted">
                Dados gerais do contrato
            </small>
        </div>

        <div class="row">

            <div class="col-md-4 mb-3">
                <div class="cliente-label">Cliente</div>
                <div class="cliente-value">
                    <div class="cliente-value">
    <a href="{{ route('clientes.show', $locacao->cliente->uuid) }}">
    {{ $locacao->cliente->nome }}
    <i class="fas fa-arrow-right fa-xs"></i>
</a>
</div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="cliente-label">Telefone</div>
                <div class="cliente-value">
                    {{ $locacao->cliente->telefone }}
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="cliente-label">Status</div>
                <div class="cliente-value">

                    @if($locacao->status == 'ativa')
                        <span class="badge badge-success">Ativa</span>
                    @elseif($locacao->status == 'atrasada')
                        <span class="badge badge-danger">Atrasada</span>
                    @else
                        <span class="badge badge-secondary">
                            {{ ucfirst($locacao->status) }}
                        </span>
                    @endif

                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="cliente-label">Bike</div>
                <div class="cliente-value">
                    <div class="cliente-value">
    <a href="{{ route('bikes.show', $locacao->bike->id) }}">
    {{ $locacao->bike->modelo }}
    <i class="fas fa-arrow-right fa-xs"></i>
</a>
</div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="cliente-label">Plano</div>
                <div class="cliente-value">
                    {{ $locacao->plano->nome }}
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="cliente-label">Valor Mensal</div>
                <div class="cliente-value">
                    R$ {{ number_format($locacao->valor_mensal,2,',','.') }}
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="cliente-label">Início</div>
                <div class="cliente-value">
                    {{ \Carbon\Carbon::parse($locacao->data_inicio)->format('d/m/Y') }}
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="cliente-label">Vencimento</div>
                <div class="cliente-value">
                    {{ \Carbon\Carbon::parse($locacao->data_vencimento)->format('d/m/Y') }}
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="cliente-label">Dias Restantes</div>

                <div class="cliente-value">

                    @php
                        $dias = now()->startOfDay()->diffInDays(
                            \Carbon\Carbon::parse($locacao->data_vencimento)->startOfDay(),
                            false
                        );
                    @endphp

                    @if($dias < 0)

                        <span class="text-danger">
                            {{ abs($dias) }} dias atrasado
                        </span>

                    @else

                        <span class="text-success">
                            {{ $dias }} dias
                        </span>

                    @endif

                </div>
            </div>

        </div>

    </div>

</div>
        

        {{-- =========================
            HISTÓRICO FINANCEIRO
        ========================== --}}
     
        <div class="card mb-4">

            <div class="card-body p-0">

                <div class="p-3">
                    <h5>Histórico Financeiro</h5>
                </div>

                <table class="table table-hover mb-0">

                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Valor</th>
                            <th>Forma</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($locacao->pagamentos as $pagamento)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($pagamento->data_pagamento)->format('d/m/Y') }}</td>
                            <td>R$ {{ number_format($pagamento->valor,2,',','.') }}</td>
                            <td>{{ ucfirst($pagamento->forma_pagamento) }}</td>
                            <td>
                        @if($pagamento->status == 'pago')

    <span class="badge badge-success">
        Pago
    </span>

@elseif($pagamento->status == 'pendente')

    <span class="badge badge-warning">
        Pendente
    </span>

@else

    <span class="badge badge-danger">
        Cancelado
    </span>

@endif 
                        </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>


        {{-- =========================
    HISTÓRICO DE RENOVAÇÕES
========================= --}}
<div class="card mb-4">

    <div class="card-body p-0">

        <div class="p-3">
            <h5>Histórico de Renovações</h5>
            <small class="text-muted">
                Todas as renovações realizadas nesta locação
            </small>
        </div>

        <table class="table table-hover mb-0">

            <thead>
                <tr>
                    <th>Data Anterior</th>
                    <th>Novo Vencimento</th>
                    <th>Valor</th>
                    <th>Registrado em</th>
                </tr>
            </thead>

            <tbody>

                @forelse($locacao->renovacoes as $renovacao)

                <tr>

                    <td>
                        {{ \Carbon\Carbon::parse($renovacao->data_anterior)->format('d/m/Y') }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($renovacao->nova_data)->format('d/m/Y') }}
                    </td>

                    <td>
                        R$ {{ number_format($renovacao->valor, 2, ',', '.') }}
                    </td>

                    <td>
                        {{ $renovacao->created_at->format('d/m/Y H:i') }}
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="4" class="text-center text-muted">
                        Nenhuma renovação registrada
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>



<div class="card shadow-sm border-0 mb-4">

    <div class="card-header bg-white border-0 pt-4 pb-2">

        <div class="d-flex align-items-center">

            <div class="event-header-icon">
                <i class="far fa-calendar-alt"></i>
            </div>

            <div>

                <h4 class="mb-1 font-weight-bold">
                    Eventos da Locação
                </h4>

                <small class="text-muted">
                    Histórico completo desta locação
                </small>

            </div>

        </div>

    </div>

    <div class="card-body pt-3">

        @forelse($eventos as $evento)

            <div class="evento-item">

                <div class="evento-icon">

                    @if(str_contains(strtolower($evento['titulo']), 'pagamento'))

                        <div class="evento-circle pagamento">
                            <i class="fas fa-dollar-sign"></i>
                        </div>

                    @elseif(str_contains(strtolower($evento['titulo']), 'renov'))

                        <div class="evento-circle renovacao">
                            <i class="fas fa-sync-alt"></i>
                        </div>

                    @else

                        <div class="evento-circle locacao">
                            <i class="fas fa-file-alt"></i>
                        </div>

                    @endif

                </div>

                <div class="evento-content">

                    <div class="evento-topo">

                        <div>

                            <div class="evento-titulo">
                                {{ $evento['titulo'] }}
                            </div>

                            <div class="evento-descricao">
                                {{ $evento['descricao'] }}
                            </div>

                        </div>

                        <div class="evento-data">
                            {{ $evento['data'] }}
                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="text-center text-muted py-5">
                Nenhum evento registrado.
            </div>

        @endforelse

    </div>

</div>


    </div>

    {{-- =========================
        AÇÕES (PADRÃO CLIENTES LATERAL)
    ========================== --}}
    <div class="col-md-4">

        <div class="card dashboard-card">
            <div class="card-body">

                <h5 class="mb-3">Ações</h5>

                <div class="actions-group">

                    <a href="https://wa.me/55{{ preg_replace('/[^0-9]/', '', $locacao->cliente->telefone) }}"
                       class="btn btn-success btn-block">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>

                    <button class="btn btn-info btn-block" data-toggle="modal" data-target="#pagamentoModal">
                        <i class="fas fa-dollar-sign"></i> Registrar Pagamento
                    </button>

  

                    <button class="btn btn-secondary btn-block" data-toggle="modal" data-target="#renovarModal{{ $locacao->uuid }}">
                        <i class="fas fa-sync"></i> Renovar
                    </button>


                    @if($locacao->status == 'ativa')
                    <button class="btn btn-warning btn-block" data-toggle="modal" data-target="#retiradaModal">
                        <i class="fas fa-truck"></i> Agendar Retirada
                    </button>
                    @endif

                    @if($locacao->status == 'aguardando_retirada')

<button
class="btn btn-danger btn-block mb-2"
data-toggle="modal"
data-target="#finalizarRetiradaModal"
>

<i class="fas fa-arrow-left"></i>

Retirada realizada

</button>

@endif

                </div>

            </div>
        </div>

        {{-- RESUMO --}}
        @include('locacoes.partials.resumo', ['locacao' => $locacao])

    </div>

</div>




<div class="modal fade"
     id="pagamentoModal"
     tabindex="-1">

    <div class="modal-dialog">

        <form action="{{ route('locacoes.pagamento', $locacao->uuid) }}"
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



<div
class="modal fade"
id="retiradaModal"
>

<div class="modal-dialog">

<div class="modal-content">

<form
method="POST"
action="{{ route(
'locacoes.agendarRetirada',
$locacao
) }}"
>

@csrf

<div class="modal-header">

<h5>

Agendar retirada

</h5>

</div>

<div class="modal-body">

<label>

Data retirada

</label>

<input
type="date"
name="data_retirada"
class="form-control"
required
>






<label class="mt-3">

Observações

</label>

<textarea
name="observacao"
class="form-control"
></textarea>

</div>

<div class="modal-footer">

<button
class="btn btn-warning"
>

Confirmar

</button>

</div>

</form>

</div>

</div>

</div>
<div
class="modal fade"
id="finalizarRetiradaModal"
>

<div class="modal-dialog">

<div class="modal-content">

<form
method="POST"
action="{{ route(
'locacoes.finalizarRetirada',
$locacao
) }}"
>

@csrf

<div class="modal-header">

<h5>

Finalizar retirada

</h5>

</div>

<div class="modal-body">

<label>

Valor multa

</label>

<input
type="number"
step="0.01"
name="multa"
class="form-control"
value="0"
>

<label class="mt-3">

Avarias

</label>

<textarea
name="avaria"
class="form-control"
></textarea>

</div>

<div class="modal-footer">

<button
class="btn btn-danger"
>

Finalizar retirada

</button>

</div>

</form>

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
@stop
@section('js')

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