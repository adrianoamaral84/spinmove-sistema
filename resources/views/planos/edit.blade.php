@extends('adminlte::page')

@section('title', 'Editar Plano')

@section('content')

<form method="POST" action="{{ route('planos.update', $plano->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nome</label>
        <input name="nome" value="{{ $plano->nome }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Valor</label>
        <input name="valor" value="{{ $plano->valor }}" type="number" step="0.01" class="form-control">
    </div>

    <div class="mb-3">
        <label>Duração</label>
        <input name="duracao_dias" value="{{ $plano->duracao_dias }}" class="form-control">
    </div>

    <button class="btn btn-primary">Atualizar</button>

</form>

@stop