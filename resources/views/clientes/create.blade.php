@extends('adminlte::page')

@section('title', 'Novo Cliente')

@section('content_header')

<div class="d-flex justify-content-between">

    <h1>Novo Cliente</h1>

</div>

@stop

@section('content')

<form method="POST"
      action="{{ route('clientes.store') }}">

@csrf

<div class="card">

<div class="card-header">

<h3 class="card-title">

Dados do Cliente

</h3>

</div>

<div class="card-body">

<!-- DADOS PESSOAIS -->

<h5 class="mb-3">

Dados Pessoais

</h5>

<div class="row">

<div class="col-md-6 mb-3">

<label>Nome</label>

<input
name="nome"
class="form-control"
>

@error('nome')

<span class="text-danger">

{{ $message }}

</span>

@enderror

</div>

<div class="col-md-6 mb-3">

<label>Telefone</label>

<input
id="telefone"
name="telefone"
class="form-control"
>

@error('telefone')

<span class="text-danger">

{{ $message }}

</span>

@enderror

</div>

<div class="col-md-6 mb-3">

<label>CPF</label>

<input
id="cpf"
name="cpf"
class="form-control"
>

@error('cpf')

<span class="text-danger">

{{ $message }}

</span>

@enderror

</div>

<div class="col-md-6 mb-3">

<label>Email</label>

<input
name="email"
class="form-control"
>

@error('email')

<span class="text-danger">

{{ $message }}

</span>

@enderror

</div>

<div class="col-md-6 mb-3">

<label>Data Nascimento</label>

<input
type="date"
name="data_nascimento"
class="form-control"
>

</div>

<div class="col-md-6 mb-3">

<label>Altura</label>

<input
name="altura"
class="form-control"
>

</div>

</div>

<hr>


<!-- ENDEREÇO -->

<h5 class="mb-3">

Endereço

</h5>

<div class="row">

<div class="col-md-6 mb-3">

<label>Endereço</label>

<input
name="endereco"
class="form-control"
>

</div>

<div class="col-md-6 mb-3">

<label>Bairro</label>

<input
name="bairro"
class="form-control"
>

</div>

</div>

<hr>


<!-- PERFIL -->

<h5 class="mb-3">

Perfil

</h5>

<div class="row">

<div class="col-md-6 mb-3">

<label>Profissão</label>

<input
name="profissao"
class="form-control"
>

</div>

<div class="col-md-6 mb-3">

<label>Estado Civil</label>

<select
name="estado_civil"
class="form-control"
>

<option value="Casado(a)">
Casado(a)
</option>

<option value="Solteiro(a)">
Solteiro(a)
</option>

<option value="Divorciado(a)">
Divorciado(a)
</option>

<option value="Viúvo(a)">
Viúvo(a)
</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label>

Onde nos conheceu

</label>

<input
name="origem"
class="form-control"
>

</div>

</div>

<hr>


<!-- COMERCIAL -->

<h5 class="mb-3">

Comercial

</h5>

<div class="row">

<div class="col-md-6 mb-3">

<label>Plano</label>

<select
name="plano_id"
class="form-control"
>

<option value="">

Selecione

</option>

@foreach($planos as $plano)

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

<div class="col-md-6 mb-3">

<label>

Status Operacional

</label>

<select
name="status"
class="form-control"
>

<option value="ativo">

Ativo

</option>

<option value="inativo">

Inativo

</option>

<option value="bloqueado">

Bloqueado

</option>

</select>

</div>

</div>

<hr>


<!-- OBSERVAÇÕES -->

<h5 class="mb-3">

Observações

</h5>

<div class="form-group">

<textarea
name="observacoes"
rows="5"
class="form-control"
></textarea>

</div>


<hr>

<div class="mt-4 mb-3">

<a
href="{{ route('clientes.index') }}"
class="btn btn-primary"
>

Cancelar

</a>

<button
class="btn btn-success"
>

Salvar

</button>

</div>

</div>

</div>

</form>

@stop


@section('js')

<script>

// CPF

document
.getElementById('cpf')
.addEventListener(
'input',
function(e){

let value =
e.target.value
.replace(/\D/g,'');

value =
value.replace(
/(\d{3})(\d)/,
'$1.$2'
);

value =
value.replace(
/(\d{3})(\d)/,
'$1.$2'
);

value =
value.replace(
/(\d{3})(\d{1,2})$/,
'$1-$2'
);

e.target.value =
value;

}
);


// TELEFONE

document
.getElementById(
'telefone'
)
.addEventListener(
'input',
function(e){

let value =
e.target.value
.replace(/\D/g,'');

value =
value.replace(
/^(\d{2})(\d)/,
'($1) $2'
);

value =
value.replace(
/(\d{5})(\d)/,
'$1-$2'
);

e.target.value =
value;

}
);

</script>

@stop