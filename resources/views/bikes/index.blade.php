@extends('adminlte::page')

@section('title', 'Bikes')
@section('css')
<link rel="stylesheet" href="{{ asset('spinmove/css/spinmove.css') }}">
@stop
@section('content_header')
<div class="mb-4">
    <h1 class="mb-1">Bikes</h1>

    <small class="text-muted">
        Gerencie toda a frota de bikes da SpinMove
    </small>
</div>
@stop


@section('content')


     <div class="section-block">
    <div class="row">

        {{-- TOTAL --}}
        <div class="col-md-2">
            <div class="card dashboard-card">
                <div class="card-body text-center">

                    <div class="dashboard-icon mx-auto mb-2 icon-gray">
                        <i class="fas fa-bicycle"></i>
                    </div>

                    <h3>{{ $totalBikes }}</h3>

                    <small class="dashboard-label">
                        Total Bikes
                    </small>

                </div>

                <div class="dashboard-line line-gray"></div>
            </div>
        </div>

        {{-- DISPONÍVEIS --}}
        <div class="col-md-2">
            <div class="card dashboard-card">
                <div class="card-body text-center">

                    <div class="dashboard-icon mx-auto mb-2 icon-green">
                        <i class="fas fa-check-circle"></i>
                    </div>

                    <h3>{{ $disponiveis }}</h3>

                    <small class="dashboard-label">
                        Disponíveis
                    </small>

                </div>

                <div class="dashboard-line line-green"></div>
            </div>
        </div>

        {{-- ALUGADAS --}}
        <div class="col-md-2">
            <div class="card dashboard-card">
                <div class="card-body text-center">

                    <div class="dashboard-icon mx-auto mb-2 icon-blue">
                        <i class="fas fa-user-clock"></i>
                    </div>

                    <h3>{{ $alugadas }}</h3>

                    <small class="dashboard-label">
                        Alugadas
                    </small>

                </div>

                <div class="dashboard-line line-blue"></div>
            </div>
        </div>

        {{-- RESERVADAS --}}
        <div class="col-md-2">
            <div class="card dashboard-card">
                <div class="card-body text-center">

                    <div class="dashboard-icon mx-auto mb-2 icon-orange">
                        <i class="fas fa-bookmark"></i>
                    </div>

                    <h3>{{ $reservadas }}</h3>

                    <small class="dashboard-label">
                        Reservadas
                    </small>

                </div>

                <div class="dashboard-line line-orange"></div>
            </div>
        </div>

        {{-- VENDIDAS --}}
        <div class="col-md-2">
            <div class="card dashboard-card">
                <div class="card-body text-center">

                    <div class="dashboard-icon mx-auto mb-2 icon-red">
                        <i class="fas fa-handshake"></i>
                    </div>

                    <h3>{{ $vendidas }}</h3>

                    <small class="dashboard-label">
                        Vendidas
                    </small>

                </div>

                <div class="dashboard-line line-red"></div>
            </div>
        </div>

        {{-- MANUTENÇÃO --}}
        <div class="col-md-2">
            <div class="card dashboard-card">
                <div class="card-body text-center">

                    <div class="dashboard-icon mx-auto mb-2 icon-gray">
                        <i class="fas fa-tools"></i>
                    </div>

                    <h3>{{ $manutencao }}</h3>

                    <small class="dashboard-label">
                        Manutenção
                    </small>

                </div>
                <div class="dashboard-line line-gray"></div>
            </div>
            </div>

                

          </div>
          </div>      

{{-- =========================
    PRÓXIMAS RETIRADAS
========================= --}}
<div class="row mb-4">

    <div class="col-md-6">

        <div class="card">

            <div class="card-header">
                Próximas Retiradas
            </div>

            <div class="card-body">

                @forelse($proximasRetiradas as $locacao)

                    <div class="mb-3">
                        <strong>{{ $locacao->cliente->nome }}</strong><br>
                        <small class="text-muted">{{ $locacao->bike->modelo }}</small><br>

                        <span class="text-danger">
                            Retirada: {{ date('d/m/Y', strtotime($locacao->data_vencimento)) }}
                        </span>
                    </div>

                    <hr>

                @empty
                    <p class="text-muted">Nenhuma retirada programada.</p>
                @endforelse

            </div>

        </div>

    </div>

</div>

{{-- =========================
    AÇÕES
========================= --}}
<div class="section-block">
    <a href="{{ route('bikes.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Nova Bike
    </a>

    <button class="btn btn-primary"
            data-toggle="modal"
            data-target="#modalLote">
        <i class="fas fa-layer-group"></i> Cadastro em lote
    </button>

</div>

{{-- =========================
    TABELA
========================= --}}
<div class="card section-block">
    <div class="card-header">
        Lista de Bikes
    </div>

    <div class="table-responsive">

        <table class="table">

            <thead>
                <tr>
                    <th>Código</th>
                    <th>Modelo</th>
                    <th>Marca</th>
                    <th>Patrimônio</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>

                @foreach($bikes as $bike)

                <tr>

                    <td><strong>{{ $bike->codigo }}</strong></td>
                    <td>{{ $bike->modelo }}</td>
                    <td>{{ $bike->marca }}</td>

                    <td>
                        @if($bike->status_patrimonial == 'ativa')
                            <span class="badge badge-success">Ativa</span>
                        @elseif($bike->status_patrimonial == 'vendida')
                            <span class="badge badge-primary">Vendida</span>
                        @elseif($bike->status_patrimonial == 'descartada')
                            <span class="badge badge-dark">Descartada</span>
                        @else
                            <span class="badge badge-danger">Roubada</span>
                        @endif
                    </td>

                    <td>
                        @if($bike->status == 'disponivel')
                            <span class="badge badge-success">Disponível</span>
                        @elseif($bike->status == 'alugada')
                            <span class="badge badge-primary">Alugada</span>
                        @elseif($bike->status == 'manutencao')
                            <span class="badge badge-warning">Manutenção</span>
                        @elseif($bike->status == 'reservada')
                            <span class="badge badge-info">Reservada</span>
                        @else
                            <span class="badge badge-danger">Inativa</span>
                        @endif
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
               href="{{ route('bikes.show', $bike->uuid) }}">

                <i class="fas fa-eye text-info mr-2"></i>
                Visualizar

            </a>

            <a class="dropdown-item"
               href="{{ route('bikes.edit', $bike->uuid) }}">

                <i class="fas fa-edit text-warning mr-2"></i>
                Editar

            </a>

            @if($bike->status_patrimonial == 'ativa')

                <div class="dropdown-divider"></div>

                <button type="button"
                        class="dropdown-item btn-vender"
                        data-toggle="modal"
                        data-target="#modalVenderBike"
                        data-id="{{ $bike->uuid }}"
                        data-modelo="{{ $bike->modelo }}">

                    <i class="fas fa-dollar-sign text-danger mr-2"></i>
                    Vender

                </button>

            @endif

            @if($bike->status == 'disponivel' && $bike->status_patrimonial == 'ativa')

                <button type="button"
                        class="dropdown-item btn-alugar"
                        data-toggle="modal"
                        data-target="#modalAlugarBike"
                        data-id="{{ $bike->uuid }}"
                        data-modelo="{{ $bike->modelo }}">

                    <i class="fas fa-bicycle text-primary mr-2"></i>
                    Alugar

                </button>

            @endif

        </div>

    </div>

</td>
                    

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

{{-- =========================
    MODAIS (mantidos intactos)
========================= --}}

<div class="modal fade"
     id="modalAlugarBike"
     tabindex="-1"
     role="dialog">

    <div class="modal-dialog">

        <form method="POST"
              action="{{ route('locacoes.store') }}">

            @csrf

            <input type="hidden"
                   name="bike_id"
                   id="locacao_bike_id">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Nova Locação
                    </h5>

                    <button type="button"
                            class="close"
                            data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    <p>
                        Bike:
                        <strong id="locacao_bike_nome"></strong>
                    </p>

                    <div class="form-group">

                        <label>Cliente</label>

                        <input type="text"
                               name="cliente"
                               class="form-control"
                               required>

                    </div>

                    <div class="form-group">

                        <label>Telefone</label>

                        <input type="text"
                               name="telefone"
                               class="form-control">

                    </div>

                    <div class="form-group">

                        <label>Valor mensal</label>

                        <input type="number"
                               step="0.01"
                               name="valor_mensal"
                               class="form-control"
                               required>

                    </div>

                    <div class="form-group">

                        <label>Data início</label>

                        <input type="date"
                               name="data_inicio"
                               class="form-control"
                               required>

                    </div>

                    <div class="form-group">

                        <label>Data vencimento</label>

                        <input type="date"
                               name="data_vencimento"
                               class="form-control"
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

                    <button type="submit"
                            class="btn btn-primary">

                        Confirmar Locação

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<div class="modal fade"
id="modalLote"
tabindex="-1">

<div class="modal-dialog modal-lg modal-dialog-scrollable">

<div class="modal-content">

<div class="modal-header">

<h5 class="modal-title">

Cadastro em lote de bikes

</h5>

<button
type="button"
class="close"
data-dismiss="modal">

<span>&times;</span>

</button>

</div>

<div class="modal-body">

<div class="row">

<div class="col-md-4 mb-3">

<label>

Quantidade

</label>

<input
id="quantidade"
type="number"
min="1"
value="10"
class="form-control" oninput="atualizarPreview()">

</div>

<div class="col-md-4 mb-3">

<label>

Marca

</label>

<input
id="marca"
class="form-control"
placeholder="Ex: SpinMove">

</div>

<div class="col-md-4 mb-3">

<label>

Modelo

</label>

<input
id="modelo"
class="form-control"
placeholder="Ex: Bike Indoor">

</div>

<div class="col-md-6 mb-3">

<label>

Valor compra

</label>

<input
id="valor_compra"
type="number"
step="0.01"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>

Data compra

</label>

<input
id="data_compra"
type="date"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>

Status inicial

</label>

<select
id="status"
class="form-control">

<option value="disponivel">

Disponível

</option>

<option value="manutencao">

Manutenção

</option>

<option value="reservada">

Reservada

</option>
<option value="inativa">

Inativa

</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label>

Prefixo código

</label>

<input
id="prefixo"
class="form-control"
value="SM"
placeholder="SM" >

<small class="text-muted">

Ex: SM-001

</small>

</div>

<div class="col-md-12 mb-3">

<label>

Observações

</label>

<textarea
id="observacao"
class="form-control"
rows="3"
placeholder="Lote compra maio / fornecedor X"></textarea>

</div>

</div>

<div
id="previewLote"
class="alert alert-light">

Nenhum lote gerado

</div>

</div>

<div class="modal-footer">

<button
type="button"
class="btn btn-secondary"
data-dismiss="modal">

Cancelar

</button>

<button
onclick="gerarLote()"
class="btn btn-success">

Criar lote

</button>

</div>

</div>

</div>

</div>
{{-- MODAL --}}
<div class="modal fade" id="modalVenderBike" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">

        <form method="POST" action="{{ route('bikes.vender') }}">

            @csrf

            <input type="hidden" name="bike_id" id="bike_id">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Vender Bike
                    </h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>

                </div>

                <div class="modal-body">

                    <p>
                        Bike:
                        <strong id="bike_nome"></strong>
                    </p>

                    <div class="form-group">
                        <label>Valor da venda</label>

                        <input type="number"
                               name="valor_venda"
                               class="form-control"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Cliente (opcional)</label>

                        <input type="text"
                               name="cliente"
                               class="form-control">
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

                    <button type="submit"
                            class="btn btn-danger">
                        Confirmar Venda
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@stop

@section('js')

<script>
$('.btn-alugar').click(function(){

    let bikeId = $(this).data('id');
    let bikeModelo = $(this).data('modelo');

    $('#locacao_bike_id').val(bikeId);

    $('#locacao_bike_nome').text(bikeModelo);

});
$(document).ready(function () {

    $('.btn-vender').on('click', function () {

        let bikeId = $(this).data('id');
        let bikeModelo = $(this).data('modelo');

        $('#bike_id').val(bikeId);
        $('#bike_nome').text(bikeModelo);

    });

});

</script>
<script>

async function gerarLote() {

    try {

        const response = await fetch(
            '{{ route("bikes.lote.store") }}',
            {
                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },

                body: JSON.stringify({

                    quantidade:
                    document.getElementById(
                        'quantidade'
                    ).value,

                    marca:
                    document.getElementById(
                        'marca'
                    ).value,

                    modelo:
                    document.getElementById(
                        'modelo'
                    ).value,

                    valor_compra:
                    document.getElementById(
                        'valor_compra'
                    ).value,

                    data_compra:
                    document.getElementById(
                        'data_compra'
                    ).value,

                    status:
                    document.getElementById(
                        'status'
                    ).value,

                    prefixo:
    document.getElementById(
        'prefixo'
    ).value

                })

            }
        );

        const data =
            await response.json();

        if (!response.ok) {

            alert(
                data.message ??
                'Erro no cadastro'
            );

            return;
        }

        $('#modalLote')
            .modal('hide');

        setTimeout(function () {

            location.reload();

        }, 500);

    }
    catch (err) {

        console.error(err);

        alert(
            'Erro ao criar lote'
        );

    }

}

</script>
<script>

function atualizarPreview(){

let qtd =
document.getElementById(
'quantidade'
).value || 0;

let prefixo =
document.getElementById(
'prefixo'
).value || 'SM';

document.getElementById(
'previewLote'
).innerHTML =

`Serão criadas:

<b>

${prefixo}-001

até

${prefixo}-${qtd}

</b>`;

}

</script>
@stop