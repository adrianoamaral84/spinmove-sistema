@php
    use App\Models\Pagamento;
@endphp
@extends('adminlte::page')

@section('title', 'Detalhes da Locação')

@section('content_header')

<div class="d-flex justify-content-between">

    <h1>

        Detalhes da Locação

    </h1>

    <a href="{{ route('locacoes.index') }}"
       class="btn btn-secondary">

        <i class="fas fa-arrow-left"></i>

        Voltar

    </a>

</div>

@stop

@section('content')

<div class="row">

    <div class="col-md-8">

        <div class="card">

            <div class="card-header">

                <h3 class="card-title">

                    Informações da Locação

                </h3>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">

                        <strong>Cliente</strong><br>

                        <a href="{{ route('clientes.show', $locacao->cliente->id) }}">

    {{ $locacao->cliente->nome }}

</a>

                    </div>

                    <div class="col-md-6">

                        <strong>Telefone</strong><br>

                        {{ $locacao->cliente->telefone }}

                    </div>

                    <div class="col-md-6 mt-3">

                        <strong>Bike</strong><br>

                        <a href="{{ route('bikes.show', $locacao->bike->id) }}">

    {{ $locacao->bike->modelo }}

</a>

                    </div>

                    <div class="col-md-6 mt-3">

                        <strong>Plano</strong><br>

                        {{ $locacao->plano->nome }}

                    </div>

                    <div class="col-md-4 mt-3">

                        <strong>Valor</strong><br>

                        R$
                        {{ number_format($locacao->valor_mensal, 2, ',', '.') }}

                    </div>

                    <div class="col-md-4 mt-3">

                        <strong>Início</strong><br>


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
                        

                    </div>

                    <div class="col-md-4 mt-3">

                        <strong>Vencimento</strong><br>
@if($locacao->data_vencimento)

{{ date(
'd/m/Y',
strtotime(
$locacao->data_vencimento
)
) }}

@else

-

@endif
              
                    </div>

                </div>

                <hr>

                <div>

                    @if($locacao->status == 'ativa')

                        <span class="badge badge-success">

                            Ativa

                        </span>

                    @elseif($locacao->status == 'atrasada')

                        <span class="badge badge-danger">

                            Atrasada

                        </span>

                    @elseif($locacao->status == 'aguardando_entrega')

                        <span class="badge badge-secondary">

                            Agurdando Entrega

                        </span>

                    @elseif($locacao->status == 'aguardando_retirada')

                        <span class="badge badge-danger">

                            Agurdando Retirada

                        </span>

                    @else

                        <span class="badge badge-secondary">

                            Finalizada

                        </span>

                    @endif

                </div>

            </div>

        </div>



        <div class="card mt-4">

    <div class="card-header">

        <h3 class="card-title">

            Histórico Financeiro

        </h3>

    </div>

    <div class="card-body">

        @if($locacao->pagamentos->count())

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>Data</th>
                    <th>Valor</th>
                    <th>Forma</th>
                    <th>Parcelas</th>
                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

                @foreach($locacao->pagamentos as $pagamento)

                <tr>

                    <td>

                        {{ \Carbon\Carbon::parse($pagamento->data_pagamento)->format('d/m/Y') }}

                    </td>

                    <td>

                        R$
                        {{ number_format($pagamento->valor, 2, ',', '.') }}

                    </td>

                    <td>

                        {{ ucfirst($pagamento->forma_pagamento) }}

                    </td>

                    <td>

                        {{ $pagamento->parcelas }}x

                    </td>

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

        @else

            <div class="alert alert-warning">

                Nenhum pagamento registrado.

            </div>

        @endif

    </div>

</div>



        <div class="card">

            <div class="card-header">

                <h3 class="card-title">

                    Histórico de Renovações

                </h3>

            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>Data Anterior</th>
                            <th>Nova Data</th>
                            <th>Valor</th>
                            <th>Data</th>

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

                                R$
                                {{ number_format($renovacao->valor, 2, ',', '.') }}

                            </td>

                            <td>

                                {{ $renovacao->created_at->format('d/m/Y H:i') }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="4">

                                Nenhuma renovação.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card">

            <div class="card-header">

                <h3 class="card-title">

                    Ações

                </h3>

            </div>

            <div class="card-body">

                <a href="https://wa.me/55{{ preg_replace('/[^0-9]/', '', $locacao->cliente->telefone) }}"
                   target="_blank"
                   class="btn btn-success btn-block mb-2">

                    <i class="fab fa-whatsapp"></i>

                    WhatsApp

                </a>

                <form action="{{ route('locacoes.renovar', $locacao->id) }}"
                      method="POST">

                    @csrf

                    <button type="button" class="btn btn-info btn-block mb-2"
        data-toggle="modal"
        data-target="#renovarModal{{ $locacao->id }}">
    
    <i class="fas fa-sync"></i>
Renovar
</button>

                </form>

                <button class="btn btn-success btn-block mb-2"
                data-toggle="modal"
                data-target="#pagamentoModal">

                <i class="fas fa-dollar-sign"></i>

                Registrar Pagamento

                </button>

                @if($locacao->status == 'ativa')

<button
class="btn btn-warning btn-block mb-2"
data-toggle="modal"
data-target="#retiradaModal"
>

<i class="fas fa-book"></i>

Agendar Retirada

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
@php

$cobrancas = Pagamento::where(
        'locacao_id',
        $locacao->id
    )
    ->where(
        'tipo',
        'cobranca'
    )
    ->get();

$saldoPendente = 0;

$totalPago = Pagamento::where(
        'locacao_id',
        $locacao->id
    )
    ->where(
        'tipo',
        'pagamento'
    )
    ->sum('valor');


foreach ($cobrancas as $cobranca) {

    $pagoDaCobranca = Pagamento::where(
            'cobranca_id',
            $cobranca->id
        )
        ->where(
            'tipo',
            'pagamento'
        )
        ->sum('valor');


    $saldo =

        $cobranca->valor

        -

        $pagoDaCobranca;


    if ($saldo > 0) {

        $saldoPendente += $saldo;

    }

}

@endphp
        <div class="card">

    <div class="card-header">

        <h3 class="card-title">

            Resumo

        </h3>

    </div>

    <div class="card-body">

        <div class="mb-3">

            <strong>Status</strong><br>

            @if($locacao->status == 'ativa')

                        <span class="badge badge-success">

                            Ativa

                        </span>

                    @elseif($locacao->status == 'atrasada')

                        <span class="badge badge-danger">

                            Atrasada

                        </span>

                    @elseif($locacao->status == 'aguardando_entrega')

                        <span class="badge badge-secondary">

                            Aguardando Entrega

                        </span>

                    @elseif($locacao->status == 'aguardando_retirada')

                        <span class="badge badge-danger">

                            Aguardando Retirada

                        </span>

                    @else

                        <span class="badge badge-secondary">

                            Finalizada

                        </span>

                    @endif

        </div>

        <div class="mb-3">

            <strong>Renovações</strong><br>

            {{ $locacao->renovacoes->count() }}

        </div>

        <div class="mb-3">

            <strong>Dias restantes</strong><br>

            @php

$dias = now()
    ->startOfDay()
    ->diffInDays(
        \Carbon\Carbon::parse(
            $locacao->data_vencimento
        )->startOfDay(),
        false
    );

@endphp

            @if($dias < 0)

    <span class="text-danger">

        {{ abs($dias) }} dias atrasado

    </span>

@else

    {{ $dias }} dias restantes

@endif

        </div>

        <div class="mb-3">

            <strong>Observações</strong><br>

            {{ $locacao->observacoes ?? '-' }}

        </div>
        





<hr>
<div class="mb-3">
<strong>Total Pago</strong>

<br>

<span class="text-info">

    R$
    {{ number_format($totalPago, 2, ',', '.') }}

</span>

</div>
<div class="mb-3">

<strong>Pagamentos</strong>

<br>

{{
     $pagamentos = Pagamento::where('locacao_id', $locacao->id)
    ->where('tipo', 'pagamento')
    ->count();
}}
</div>
<div class="mb-3">

<strong>Saldo Pendente</strong>

<br>

@if($cobrancas->count() <= 0)
    <span class="badge badge-secondary">
        Sem cobrança
    </span>

@elseif($saldoPendente <= 0)

    <span class="badge badge-success">
        Quitado
    </span>

@elseif($totalPago > 0)

    <span class="badge badge-warning">
        Parcial
    </span>

    <span class="badge badge-danger">
        R$ {{ number_format($saldoPendente, 2, ',', '.') }} pendente
    </span>

@else

    <span class="badge badge-danger">
        Pendente
    </span>
    <span class="badge badge-danger">
        R$ {{ number_format($saldoPendente, 2, ',', '.') }} pendente
    </span>
@endif
</div>



















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
     id="renovarModal{{ $locacao->id }}"
     tabindex="-1">

    <div class="modal-dialog">

        <form action="{{ route('locacoes.renovar', $locacao->id) }}"
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

<div class="modal fade"
     id="pagamentoModal"
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