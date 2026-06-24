@extends('adminlte::page')

@section('title', 'Editar Bike')

@section('content')

<div class="content-header section-block">
    <h3 class="mb-0">Editar Bike</h3>
    <small class="text-muted">
        Atualize as informações da bicicleta
    </small>
</div>

<div class="section-block">

    <div class="card">

        <div class="card-header">
            Dados da Bike
        </div>

        <div class="card-body">

            <form action="{{ route('bikes.update', $bike->uuid) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- CÓDIGO --}}
                    <div class="col-md-4 mb-3">
                        <label>Código</label>
                        <input type="text"
                               name="codigo"
                               class="form-control"
                               value="{{ $bike->codigo }}"
                               required>
                    </div>

                    {{-- MODELO --}}
                    <div class="col-md-4 mb-3">
                        <label>Modelo</label>
                        <input type="text"
                               name="modelo"
                               class="form-control"
                               value="{{ $bike->modelo }}"
                               required>
                    </div>

                    {{-- MARCA --}}
                    <div class="col-md-4 mb-3">
                        <label>Marca</label>
                        <input type="text"
                               name="marca"
                               class="form-control"
                               value="{{ $bike->marca }}"
                               required>
                    </div>

                    {{-- STATUS --}}
                    <div class="col-md-6 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">

                            <option value="disponivel" {{ $bike->status == 'disponivel' ? 'selected' : '' }}>
                                Disponível
                            </option>

                            <option value="alugada" {{ $bike->status == 'alugada' ? 'selected' : '' }}>
                                Alugada
                            </option>

                            <option value="manutencao" {{ $bike->status == 'manutencao' ? 'selected' : '' }}>
                                Manutenção
                            </option>

                            <option value="reservada" {{ $bike->status == 'reservada' ? 'selected' : '' }}>
                                Reservada
                            </option>

                            <option value="inativa" {{ $bike->status == 'inativa' ? 'selected' : '' }}>
                                Inativa
                            </option>

                        </select>
                    </div>

                    {{-- STATUS PATRIMONIAL --}}
                    <div class="col-md-6 mb-3">
                        <label>Status Patrimonial</label>
                        <select name="status_patrimonial" class="form-control">

                            <option value="ativa" {{ $bike->status_patrimonial == 'ativa' ? 'selected' : '' }}>
                                Ativa
                            </option>

                            <option value="vendida" {{ $bike->status_patrimonial == 'vendida' ? 'selected' : '' }}>
                                Vendida
                            </option>

                            <option value="descartada" {{ $bike->status_patrimonial == 'descartada' ? 'selected' : '' }}>
                                Descartada
                            </option>

                            <option value="roubada" {{ $bike->status_patrimonial == 'roubada' ? 'selected' : '' }}>
                                Roubada
                            </option>

                        </select>
                    </div>

                    {{-- VALOR COMPRA --}}
                    <div class="col-md-6 mb-3">
                        <label>Valor de Compra</label>
                        <input type="number"
                               step="0.01"
                               name="valor_compra"
                               class="form-control"
                               value="{{ $bike->valor_compra }}">
                    </div>

                    {{-- DATA COMPRA --}}
                    <div class="col-md-6 mb-3">
                        <label>Data da Compra</label>
                        <input type="date"
                               name="data_compra"
                               class="form-control"
                               value="{{ $bike->data_compra }}">
                    </div>

                </div>

                {{-- AÇÕES --}}
                <div class="section-block actions-group">

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Atualizar Bike
                    </button>

                    <a href="{{ route('bikes.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@stop