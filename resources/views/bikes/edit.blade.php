@extends('adminlte::page')

@section('title', 'Editar Bike')

@section('content_header')
    <h1>Editar Bike</h1>
@stop

@section('content')

<div class="card">

    <div class="card-body">

        <form action="{{ route('bikes.update', $bike->uuid) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="form-group">

                <label>Código</label>

                <input type="text"
                       name="codigo"
                       class="form-control"
                       value="{{ $bike->codigo }}"
                       required>

            </div>

            <div class="form-group">

                <label>Modelo</label>

                <input type="text"
                       name="modelo"
                       class="form-control"
                       value="{{ $bike->modelo }}"
                       required>

            </div>

            <div class="form-group">

                <label>Marca</label>

                <input type="text"
                       name="marca"
                       class="form-control"
                       value="{{ $bike->marca }}"
                       required>

            </div>

            <div class="form-group">

                <label>Status</label>

                <select name="status"
                        class="form-control">

                    <option value="disponivel"
                        {{ $bike->status == 'disponivel' ? 'selected' : '' }}>
                        Disponível
                    </option>

                    <option value="alugada"
                        {{ $bike->status == 'alugada' ? 'selected' : '' }}>
                        Alugada
                    </option>

                    <option value="manutencao"
                        {{ $bike->status == 'manutencao' ? 'selected' : '' }}>
                        Manutenção
                    </option>

                    <option value="reservada"
                        {{ $bike->status == 'reservada' ? 'selected' : '' }}>
                        Reservada
                    </option>

                    <option value="inativa"
                        {{ $bike->status == 'inativa' ? 'selected' : '' }}>
                        Inativa
                    </option>

                </select>

            </div>

            <div class="form-group">

                <label>Status Patrimonial</label>

                <select name="status_patrimonial"
                        class="form-control">

                    <option value="ativa"
                        {{ $bike->status_patrimonial == 'ativa' ? 'selected' : '' }}>
                        Ativa
                    </option>

                    <option value="vendida"
                        {{ $bike->status_patrimonial == 'vendida' ? 'selected' : '' }}>
                        Vendida
                    </option>

                    <option value="descartada"
                        {{ $bike->status_patrimonial == 'descartada' ? 'selected' : '' }}>
                        Descartada
                    </option>

                    <option value="roubada"
                        {{ $bike->status_patrimonial == 'roubada' ? 'selected' : '' }}>
                        Roubada
                    </option>

                </select>

            </div>

            <div class="form-group">

                <label>Valor de Compra</label>

                <input type="number"
                       step="0.01"
                       name="valor_compra"
                       class="form-control"
                       value="{{ $bike->valor_compra }}">

            </div>

            <div class="form-group">

                <label>Data da Compra</label>

                <input type="date"
                       name="data_compra"
                       class="form-control"
                       value="{{ $bike->data_compra }}">

            </div>

            
            

            <button class="btn btn-success">

                Atualizar Bike

            </button>

        </form>

    </div>

</div>

@stop