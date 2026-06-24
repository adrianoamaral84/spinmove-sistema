@extends('adminlte::page')

@section('title', 'Nova Bike')
@section('css')
<link rel="stylesheet" href="{{ asset('spinmove/css/spinmove.css') }}">
@stop
@section('content')

<div class="content-header section-block">
    <h3 class="mb-0">Nova Bike</h3>
    <small class="text-muted">Cadastro de nova bicicleta na frota</small>
</div>

<div class="section-block">

    <div class="card">

        <div class="card-header">
            Dados da Bike
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('bikes.store') }}">

                @csrf

                <div class="row">

                    {{-- MODELO --}}
                    <div class="col-md-6 mb-3">
                        <label>Modelo</label>
                        <input type="text"
                               name="modelo"
                               class="form-control"
                               placeholder="Ex: Bike Indoor Pro">
                    </div>

                    {{-- MARCA --}}
                    <div class="col-md-6 mb-3">
                        <label>Marca</label>
                        <input type="text"
                               name="marca"
                               class="form-control"
                               placeholder="Ex: SpinMove">
                    </div>

                    {{-- VALOR COMPRA --}}
                    <div class="col-md-6 mb-3">
                        <label>Valor de Compra</label>
                        <input type="number"
                               step="0.01"
                               name="valor_compra"
                               class="form-control"
                               placeholder="0,00">
                    </div>

                    {{-- DATA COMPRA --}}
                    <div class="col-md-6 mb-3">
                        <label>Data da Compra</label>
                        <input type="date"
                               name="data_compra"
                               class="form-control">
                    </div>

                    {{-- STATUS --}}
                    <div class="col-md-6 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">

                            <option value="disponivel">Disponível</option>
                            <option value="manutencao">Manutenção</option>
                            <option value="reservada">Reservada</option>
                            <option value="inativa">Inativa</option>

                        </select>
                    </div>

                </div>

                {{-- BOTÃO --}}
                <div class="section-block">
<a href="{{ route('bikes.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Salvar Bike
                    </button>

                    

                </div>

            </form>

        </div>

    </div>

</div>

@stop