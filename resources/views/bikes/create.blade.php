@extends('adminlte::page')

@section('title', 'Nova Bike')

@section('content_header')
    <h1>Nova Bike</h1>
@stop

@section('content')

<form method="POST" action="{{ route('bikes.store') }}">

    @csrf

    <div class="row">

        

        <div class="col-md-6 mt-3">

            <label>Modelo</label>

            <input type="text"
                   name="modelo"
                   class="form-control">

        </div>

        <div class="col-md-6 mt-3">

            <label>Marca</label>

            <input type="text"
                   name="marca"
                   class="form-control">

        </div>


        <div class="col-md-6 mt-3">

    <label>Valor de Compra</label>

    <input type="number"
           step="0.01"
           name="valor_compra"
           class="form-control">

</div>

<div class="col-md-6 mt-3">

    <label>Data da Compra</label>

    <input type="date"
           name="data_compra"
           class="form-control">

</div>


        

        <div class="col-md-6 mt-3">

            <label>Status</label>

            <select name="status"
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

        

    </div>

    <button class="btn btn-success mt-4">

        Salvar

    </button>

</form>

@stop