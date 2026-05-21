@extends('adminlte::page')

@section('title', 'Novo Plano')

@section('content')

<form method="POST" action="{{ route('planos.store') }}">
    @csrf

    <div class="mb-3">
        <label>Nome</label>
        <input name="nome" class="form-control">
    </div>

    <div class="mb-3">
        <label>Valor</label>
        <input name="valor" type="number" step="0.01" class="form-control">
    </div>

    <div class="mb-3">
        <label>Duração (dias)</label>
        <input name="duracao_dias" type="number" class="form-control">
    </div>

    <button class="btn btn-success">Salvar</button>

</form>

@stop