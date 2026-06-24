@extends('adminlte::page')

@section('title', 'Novo Cliente')

@section('content_header')

@section('content_header')
<div class="mb-4">
    <h1 class="mb-1">Novo Cliente</h1>

    <small class="text-muted">
        Cadastro de novo cliente SpinMove
    </small>
</div>
@stop
@stop

@section('content')

<form method="POST"
      action="{{ route('clientes.store') }}">

@csrf

<div class="card">

<div class="card-header spinmove-header">

    <h3 class="card-title mb-0">

        <i class="fas fa-user-plus mr-2"></i>

        Dados do Cliente

    </h3>

</div>

<div class="card-body">

<!-- DADOS PESSOAIS -->

<h5 class="mb-4 border-bottom pb-2">
    <i class="fas fa-user text-orange mr-2"></i>
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

<h5 class="mb-4 border-bottom pb-2">
    <i class="fas fa-map-marker-alt text-orange mr-2"></i>
    Endereço
</h5>

<div class="row">

    <div class="col-md-3 mb-3">

        <label>CEP</label>

        <input
            id="cep"
            name="cep"
            class="form-control"
            value="{{ old('cep') }}"
            required>

    </div>

    <div class="col-md-6 mb-3">

        <label>Endereço</label>

        <input
            id="endereco"
            name="endereco"
            class="form-control"
            value="{{ old('endereco') }}"
            required>

    </div>

    <div class="col-md-3 mb-3">

        <label>Número</label>

        <input
            name="numero"
            class="form-control"
            value="{{ old('numero') }}"
            required>

    </div>

</div>

<div class="row">

    <div class="col-md-4 mb-3">

        <label>Bairro</label>

        <input
            id="bairro"
            name="bairro"
            class="form-control"
            value="{{ old('bairro') }}"
            required>

    </div>

    <div class="col-md-4 mb-3">

        <label>Cidade</label>

        <input
            id="cidade"
            name="cidade"
            class="form-control"
            value="{{ old('cidade') }}"
            required>

    </div>

    <div class="col-md-4 mb-3">

        <label>Estado</label>

        <input
            id="estado"
            name="estado"
            class="form-control"
            value="{{ old('estado') }}"
            readonly>

    </div>

</div>

<hr>


<!-- PERFIL -->

<h5 class="mb-4 border-bottom pb-2">
    <i class="fas fa-id-card text-orange mr-2"></i>
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

Como conheceu a SpinMove?

</label>

<select
name="origem"
class="form-control"
required>

<option value="">
Selecione
</option>

<option value="Instagram"
{{ old('origem')=='Instagram' ? 'selected':'' }}>
Instagram
</option>

<option value="Indicação"
{{ old('origem')=='Indicação' ? 'selected':'' }}>
Indicação
</option>

<option value="Google"
{{ old('origem')=='Google' ? 'selected':'' }}>
Google
</option>

<option value="Facebook"
{{ old('origem')=='Facebook' ? 'selected':'' }}>
Facebook
</option>

<option value="Passando na rua"
{{ old('origem')=='Passando na rua' ? 'selected':'' }}>
Passando na rua
</option>

<option value="Outro"
{{ old('origem')=='Outro' ? 'selected':'' }}>
Outro
</option>

</select>

</div>

</div>

<hr>


<!-- COMERCIAL -->

<h5 class="mb-4 border-bottom pb-2">
    <i class="fas fa-briefcase text-orange mr-2"></i>
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

{{ number_format($plano->valor,2,',','.') }}

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

<h5 class="mb-4 border-bottom pb-2">
    <i class="fas fa-sticky-note text-orange mr-2"></i>
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
class="btn btn-light border"
>
<i class="fas fa-arrow-left mr-1"></i>
Voltar
</a>

<button
class="btn btn-success"
>
<i class="fas fa-save mr-1"></i>
Salvar Cliente
</button>

</div>

</div>

</div>

</form>

@stop


@section('js')
<script>

document.getElementById('cep')
.addEventListener('input', function(e){

    let value = e.target.value
        .replace(/\D/g,'');

    value = value.replace(
        /^(\d{5})(\d)/,
        '$1-$2'
    );

    e.target.value = value;

});

</script>
<script>

document.getElementById('cep')
.addEventListener('blur', function(){

    let cep = this.value.replace(/\D/g,'');

    if(cep.length !== 8){
        return;
    }

    fetch(
        `https://viacep.com.br/ws/${cep}/json/`
    )
    .then(response => response.json())
    .then(data => {

        if(data.erro){

            alert('CEP não encontrado.');

            return;
        }

        document.getElementById('endereco')
            .value = data.logradouro || '';

        document.getElementById('bairro')
            .value = data.bairro || '';

        document.getElementById('cidade')
            .value = data.localidade || '';

        document.getElementById('estado')
            .value = data.uf || '';

    })
    .catch(() => {

        alert(
            'Erro ao consultar o CEP.'
        );

    });

});

</script>
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