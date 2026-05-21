<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width,initial-scale=1">

<title>

Cadastro SpinMove

</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

body{

background:#f5f6fa;

}

.card{

border:none;

border-radius:20px;

box-shadow:

0 10px 30px rgba(
0,0,0,.08
);

}

.logo{

font-size:28px;

font-weight:700;

color:#ff7a00;

}

.section{

font-size:18px;

font-weight:600;

margin-bottom:20px;

}

</style>

</head>

<body>

<div class="container py-4">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="text-center mb-4">

<div class="logo">

SPINMOVE

</div>

<p>

Preencha seu cadastro

</p>

</div>

<form
method="POST"
action="{{ route('cadastro.publico.store') }}"
>

@csrf

<div class="card">

<div class="card-body p-4">

<div class="section">

Dados pessoais

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label>

Nome completo

</label>

<input
name="nome"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>

Telefone

</label>

<input
id="telefone"
name="telefone"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>

CPF

</label>

<input
id="cpf"
name="cpf"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>

Email

</label>

<input
name="email"
type="email"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>

Nascimento

</label>

<input
type="date"
name="data_nascimento"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>

Altura

</label>

<input
name="altura"
class="form-control">

</div>

</div>

<hr>

<div class="section">

Endereço

</div>

<div class="row">

<div class="col-md-8 mb-3">

<label>

Endereço

</label>

<input
name="endereco"
class="form-control">

</div>

<div class="col-md-4 mb-3">

<label>

Bairro

</label>

<input
name="bairro"
class="form-control">

</div>

</div>

<hr>

<div class="section">

Perfil

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label>

Profissão

</label>

<input
name="profissao"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>

Estado civil

</label>

<select
name="estado_civil"
class="form-control">

<option>

Solteiro(a)

</option>

<option>

Casado(a)

</option>

<option>

Divorciado(a)

</option>

<option>

Viúvo

</option>

</select>

</div>

</div>

<hr>

<div class="section">

Plano desejado

</div>

<select
name="plano_id"
class="form-control mb-4">

<option>

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

<button
class="btn btn-warning w-100 btn-lg">

Enviar cadastro

</button>

</div>

</div>

</form>

</div>

</div>

</div>

<script>

document
.getElementById(
'cpf'
)
.addEventListener(
'input',
function(e){

let value=
e.target.value
.replace(
/\D/g,
''
);

value=
value.replace(
/(\d{3})(\d)/,
'$1.$2'
);

value=
value.replace(
/(\d{3})(\d)/,
'$1.$2'
);

value=
value.replace(
/(\d{3})(\d{1,2})$/,
'$1-$2'
);

e.target.value=
value;

}
);

document
.getElementById(
'telefone'
)
.addEventListener(
'input',
function(e){

let value=
e.target.value
.replace(
/\D/g,
''
);

value=
value.replace(
/^(\d{2})(\d)/,
'($1) $2'
);

value=
value.replace(
/(\d{5})(\d)/,
'$1-$2'
);

e.target.value=
value;

}
);

</script>

</body>

</html>