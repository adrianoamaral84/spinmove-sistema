@extends('adminlte::page')

@section('title', 'Bikes')

@section('content_header')
    <h1>Bikes</h1>
@stop

@section('content')
<div class="row mb-4">

<div class="col-md-2">

<div class="small-box bg-info">

<div class="inner">

<h3>

{{ $totalBikes }}

</h3>

<p>Total Bikes</p>

</div>

</div>

</div>



<div class="col-md-2">

<div class="small-box bg-success">

<div class="inner">

<h3>

{{ $disponiveis }}

</h3>

<p>Disponíveis</p>

</div>

</div>

</div>



<div class="col-md-2">

<div class="small-box bg-primary">

<div class="inner">

<h3>

{{ $alugadas }}

</h3>

<p>Alugadas</p>

</div>

</div>

</div>



<div class="col-md-2">

<div class="small-box bg-warning">

<div class="inner">

<h3>

{{ $reservadas }}

</h3>

<p>Reservadas</p>

</div>

</div>

</div>



<div class="col-md-2">

<div class="small-box bg-danger">

<div class="inner">

<h3>

{{ $vendidas }}

</h3>

<p>Vendidas</p>

</div>

</div>

</div>



<div class="col-md-2">

<div class="small-box bg-secondary">

<div class="inner">

<h3>

{{ $manutencao }}

</h3>

<p>Manutenção</p>

</div>

</div>

</div>

</div>

<div class="row mb-4">

<div class="col-md-6">

<div class="card">

<div class="card-header bg-warning">

<h3 class="card-title">

Próximas Retiradas

</h3>

</div>

<div class="card-body">

@forelse($proximasRetiradas as $locacao)

<div class="mb-2">

<strong>

{{ $locacao
->cliente
->nome }}

</strong>

<br>

<small>

{{ $locacao
->bike
->modelo }}

</small>

<br>

<small class="text-danger">

Retirada:

{{

date(

'd/m/Y',

strtotime(

$locacao
->data_vencimento

)

)

}}

</small>

</div>

<hr>

@empty

Nenhuma retirada.

@endforelse

</div>

</div>

</div>

</div>
<div class="mb-3">
    <a href="{{ route('bikes.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i>
        Nova Bike
    </a>
</div>

<table class="table table-bordered table-hover">

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

            <td>
                <strong>{{ $bike->codigo }}</strong>
            </td>

            <td>{{ $bike->modelo }}</td>

            <td>{{ $bike->marca }}</td>

            <td>

                @if($bike->status_patrimonial == 'ativa')

                    <span class="badge badge-success">
                        Ativa
                    </span>

                @elseif($bike->status_patrimonial == 'vendida')

                    <span class="badge badge-primary">
                        Vendida
                    </span>

                @elseif($bike->status_patrimonial == 'descartada')

                    <span class="badge badge-dark">
                        Descartada
                    </span>

                @else

                    <span class="badge badge-danger">
                        Roubada
                    </span>

                @endif

            </td>

            <td>

                @if($bike->status == 'disponivel')

                    <span class="badge badge-success">
                        Disponível
                    </span>

                @elseif($bike->status == 'alugada')

                    <span class="badge badge-primary">
                        Alugada
                    </span>

                @elseif($bike->status == 'manutencao')

                    <span class="badge badge-warning">
                        Manutenção
                    </span>

                @elseif($bike->status == 'reservada')

                    <span class="badge badge-info">
                        Reservada
                    </span>

                @else

                    <span class="badge badge-danger">
                        Inativa
                    </span>

                @endif

            </td>

            <td>
<a href="{{ route('bikes.show', $bike->id) }}"
   class="btn btn-info btn-sm">

    <i class="fas fa-eye"></i>

</a>

<a href="{{ route('bikes.edit', $bike->id) }}"
   class="btn btn-warning btn-sm">

    <i class="fas fa-edit"></i>

</a>
                @if($bike->status_patrimonial == 'ativa')

                    <button type="button"
        class="btn btn-danger btn-sm btn-vender"
        data-toggle="modal"
        data-target="#modalVenderBike"
        data-id="{{ $bike->id }}"
        data-modelo="{{ $bike->modelo }}">
    Vender
</button>

                @endif


                @if(
    $bike->status == 'disponivel' &&
    $bike->status_patrimonial == 'ativa'
)

<button type="button"
        class="btn btn-primary btn-sm btn-alugar"
        data-toggle="modal"
        data-target="#modalAlugarBike"
        data-id="{{ $bike->id }}"
        data-modelo="{{ $bike->modelo }}">
    Alugar
</button>

@endif

            </td>

        </tr>

        @endforeach

    </tbody>

</table>
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

@stop