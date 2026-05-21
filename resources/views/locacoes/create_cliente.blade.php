@extends('adminlte::page')

@section('title', 'Nova Locação')

@section('content_header')

<div class="d-flex justify-content-between">

    <h1>

        Nova Locação

    </h1>

    <a
    href="{{ route(
        'clientes.show',
        $cliente->id
    ) }}"
    class="btn btn-secondary"
    >

        Voltar

    </a>

</div>

@stop


@section('content')

<div class="card">

<div class="card-body">

<form
action="{{ route(
'locacoes.store'
) }}"
method="POST">

@csrf


<input
type="hidden"
name="cliente_id"
value="{{ $cliente->id }}"
>


<div class="form-group">

<label>

Cliente

</label>

<input
class="form-control"
value="{{ $cliente->nome }}"
readonly
>

</div>


<div class="form-group">

<label>

Bike

</label>

<select
name="bike_id"
class="form-control select2"
required
>

@foreach(
$bikes as $bike
)

<option
value="{{ $bike->id }}"
>

{{ $bike->codigo }}

-

{{ $bike->modelo }}

</option>

@endforeach

</select>

</div>


<div class="form-group">

<label>

Plano

</label>

<select
name="plano_id"
class="form-control select2"
required
>

@foreach(
$planos as $plano
)

<option
value="{{ $plano->id }}"
>

{{ $plano->nome }}

-

R$

{{ number_format(

$plano->valor,

2,

',',

'.'

) }}

</option>

@endforeach

</select>

</div>


<div class="form-group">

<label>

Observações

</label>

<textarea
name="observacoes"
class="form-control"
></textarea>

</div>


<button
class="btn btn-success"
>

Criar Locação

</button>

</form>

</div>

</div>

@stop