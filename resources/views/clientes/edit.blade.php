@extends('adminlte::page')

@section('title', 'Editar Cliente')

@section('css')
<link rel="stylesheet" href="{{ asset('spinmove/css/spinmove.css') }}">
@stop

@section('content_header')
<div class="mb-4">
    <h1 class="mb-1">Editar Cliente</h1>
    <small class="text-muted">
        Atualize os dados cadastrais do cliente
    </small>
</div>
@stop

@section('content')

<form method="POST" action="{{ route('clientes.update', $cliente->uuid) }}">
@csrf
@method('PUT')

<div class="card">

    <div class="card-header spinmove-header">
        <h3 class="card-title mb-0">
            Dados do Cliente
        </h3>
    </div>

    <div class="card-body">

        {{-- DADOS PESSOAIS --}}

        <h5 class="text-orange mb-4">
            Dados Pessoais
        </h5>

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>Nome</label>
                <input
                    name="nome"
                    value="{{ old('nome',$cliente->nome) }}"
                    class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Telefone</label>
                <input
                    id="telefone"
                    name="telefone"
                    value="{{ old('telefone',$cliente->telefone) }}"
                    class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>CPF</label>
                <input
                    id="cpf"
                    name="cpf"
                    value="{{ old('cpf',$cliente->cpf) }}"
                    class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input
                    name="email"
                    value="{{ old('email',$cliente->email) }}"
                    class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Data de Nascimento</label>
                <input
                    type="date"
                    name="data_nascimento"
                    value="{{ old('data_nascimento',$cliente->data_nascimento ? $cliente->data_nascimento->format('Y-m-d') : '') }}"
                    class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Altura</label>
                <input
                    name="altura"
                    value="{{ old('altura',$cliente->altura) }}"
                    class="form-control">
            </div>

        </div>

        <hr>

        {{-- ENDEREÇO --}}

        <h5 class="text-orange mb-4">
    Endereço
</h5>

<div class="row">

    <div class="col-md-3 mb-3">
        <label>CEP</label>

        <input
            id="cep"
            name="cep"
            value="{{ old('cep',$cliente->cep) }}"
            class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label>Endereço</label>

        <input
            id="endereco"
            name="endereco"
            value="{{ old('endereco',$cliente->endereco) }}"
            class="form-control">
    </div>

    <div class="col-md-3 mb-3">
        <label>Número</label>

        <input
            name="numero"
            value="{{ old('numero',$cliente->numero) }}"
            class="form-control">
    </div>

</div>

<div class="row">

    <div class="col-md-4 mb-3">
        <label>Bairro</label>

        <input
            id="bairro"
            name="bairro"
            value="{{ old('bairro',$cliente->bairro) }}"
            class="form-control">
    </div>

    <div class="col-md-4 mb-3">
        <label>Cidade</label>

        <input
            id="cidade"
            name="cidade"
            value="{{ old('cidade',$cliente->cidade) }}"
            class="form-control">
    </div>

    <div class="col-md-4 mb-3">
        <label>Estado</label>

        <input
            id="estado"
            name="estado"
            value="{{ old('estado',$cliente->estado) }}"
            class="form-control"
            readonly>
    </div>

</div>

        <hr>

        {{-- PERFIL --}}

        <h5 class="text-orange mb-4">
            Perfil
        </h5>

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>Profissão</label>
                <input
                    name="profissao"
                    value="{{ old('profissao',$cliente->profissao) }}"
                    class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Estado Civil</label>

                <select name="estado_civil" class="form-control">

                    <option value="Solteiro(a)" {{ $cliente->estado_civil == 'Solteiro(a)' ? 'selected' : '' }}>
                        Solteiro(a)
                    </option>

                    <option value="Casado(a)" {{ $cliente->estado_civil == 'Casado(a)' ? 'selected' : '' }}>
                        Casado(a)
                    </option>

                    <option value="Divorciado(a)" {{ $cliente->estado_civil == 'Divorciado(a)' ? 'selected' : '' }}>
                        Divorciado(a)
                    </option>

                    <option value="Viúvo(a)" {{ $cliente->estado_civil == 'Viúvo(a)' ? 'selected' : '' }}>
                        Viúvo(a)
                    </option>

                </select>

            </div>

            <div class="col-md-6 mb-3">

    <label>Como conheceu a SpinMove?</label>

    <select name="origem" class="form-control">

        <option value="">
            Selecione
        </option>

        <option value="Instagram"
            {{ old('origem',$cliente->origem) == 'Instagram' ? 'selected' : '' }}>
            Instagram
        </option>

        <option value="Indicação"
            {{ old('origem',$cliente->origem) == 'Indicação' ? 'selected' : '' }}>
            Indicação
        </option>

        <option value="Google"
            {{ old('origem',$cliente->origem) == 'Google' ? 'selected' : '' }}>
            Google
        </option>

        <option value="Facebook"
            {{ old('origem',$cliente->origem) == 'Facebook' ? 'selected' : '' }}>
            Facebook
        </option>

        <option value="Passando na rua"
            {{ old('origem',$cliente->origem) == 'Passando na rua' ? 'selected' : '' }}>
            Passando na rua
        </option>

        <option value="Outro"
            {{ old('origem',$cliente->origem) == 'Outro' ? 'selected' : '' }}>
            Outro
        </option>

    </select>

</div>

        </div>

        <hr>

        {{-- COMERCIAL --}}

        <h5 class="text-orange mb-4">
            Comercial
        </h5>

        <div class="row">

            <div class="col-md-6 mb-3">

                <label>Plano</label>

                <select name="plano_id" class="form-control">

                    <option value="">
                        Selecione
                    </option>

                    @foreach($planos as $plano)

                    <option
                        value="{{ $plano->id }}"
                        {{ $cliente->plano_id == $plano->id ? 'selected' : '' }}>

                        {{ $plano->nome }}
                        - R$ {{ number_format($plano->valor,2,',','.') }}

                    </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-6 mb-3">

                <label>Status</label>

                <select name="status" class="form-control">

                    <option value="ativo" {{ $cliente->status == 'ativo' ? 'selected' : '' }}>
                        Ativo
                    </option>

                    <option value="inativo" {{ $cliente->status == 'inativo' ? 'selected' : '' }}>
                        Inativo
                    </option>

                    <option value="bloqueado" {{ $cliente->status == 'bloqueado' ? 'selected' : '' }}>
                        Bloqueado
                    </option>

                </select>

            </div>

        </div>

        <hr>

        {{-- OBSERVAÇÕES --}}

        <h5 class="text-orange mb-4">
            Observações
        </h5>

        <textarea
            name="observacoes"
            rows="5"
            class="form-control">{{ old('observacoes',$cliente->observacoes) }}</textarea>

        <div class="mt-4">

            <a
                href="{{ route('clientes.index') }}"
                class="btn btn-secondary">

                Cancelar

            </a>

            <button
                type="submit"
                class="btn btn-success">

                Atualizar Cliente

            </button>

        </div>

    </div>

</div>

</form>
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

    fetch(`https://viacep.com.br/ws/${cep}/json/`)
    .then(response => response.json())
    .then(data => {

        if(data.erro){
            return;
        }

        document.getElementById('endereco').value =
            data.logradouro || '';

        document.getElementById('bairro').value =
            data.bairro || '';

        document.getElementById('cidade').value =
            data.localidade || '';

        document.getElementById('estado').value =
            data.uf || '';

    });

});

</script>
<script>

document.getElementById('cpf')
.addEventListener('input', function(e){

    let value =
    e.target.value.replace(/\D/g,'');

    value =
    value.replace(/(\d{3})(\d)/,'$1.$2');

    value =
    value.replace(/(\d{3})(\d)/,'$1.$2');

    value =
    value.replace(/(\d{3})(\d{1,2})$/,'$1-$2');

    e.target.value = value;

});

</script>
<script>

document.getElementById('telefone')
.addEventListener('input', function(e){

    let value =
    e.target.value.replace(/\D/g,'');

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

    e.target.value = value;

});

</script>
@stop