@extends('adminlte::page')

@section('title', 'Planos')

@section('content_header')
    <h1>Planos</h1>
@stop

@section('content')

<a href="{{ route('planos.create') }}" class="btn btn-primary mb-3">
    + Novo Plano
</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Valor</th>
            <th>Duração</th>
            <th>Ações</th>
        </tr>
    </thead>

    <tbody>
        @foreach($planos as $plano)
        <tr>
            <td>{{ $plano->nome }}</td>
            <td>R$ {{ $plano->valor }}</td>
            <td>{{ $plano->duracao_dias }} dias</td>
            <td>
                <a href="{{ route('planos.edit', $plano->id) }}" class="btn btn-warning btn-sm">Editar</a>

                <form action="{{ route('planos.destroy', $plano->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Excluir</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

@stop