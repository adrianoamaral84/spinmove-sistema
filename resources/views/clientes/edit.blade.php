@extends('adminlte::page')

@section('title', 'Editar Cliente')

@section('content_header')
    <h1>Editar Cliente</h1>
@stop

@section('content')


            <form method="POST" action="{{ route('clientes.update', $cliente->id) }}">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6">
                        <label>Nome</label>
                        <input name="nome" value="{{ old('nome', $cliente->nome) }}"
                            class="form-control">
                        @error('nome') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6">
                        <label>Telefone</label>
                        <input name="telefone" value="{{ old('telefone', $cliente->telefone) }}"
                             class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>CPF</label>
                        <input name="cpf" value="{{ old('cpf', $cliente->cpf) }}"
                             class="form-control">
                        @error('cpf') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6">
                        <label>Email</label>
                        <input name="email" value="{{ old('email', $cliente->email) }}"
                             class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Endereço</label>
                        <input name="endereco" value="{{ old('endereco', $cliente->endereco) }}"
                             class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Bairro</label>
                        <input name="bairro" value="{{ old('bairro', $cliente->bairro) }}"
                             class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Profissão</label>
                        <input name="profissao" value="{{ old('profissao', $cliente->profissao) }}"
                             class="form-control">
                    </div>

                    <div class="col-md-6 mt-3">
    <label>Estado Civil</label>
    <select name="estado_civil" class="form-control">
        <option value="Solteiro(a)" {{ $cliente->estado_civil == 'Solteiro(a)' ? 'selected' : '' }}>Solteiro(a)</option>
        <option value="Casado(a)" {{ $cliente->estado_civil == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
        <option value="Divorciado(a)" {{ $cliente->estado_civil == 'Divorciado(a)' ? 'selected' : '' }}>Divorciado(a)</option>
        <option value="Viúvo" {{ $cliente->estado_civil == 'Viúvo' ? 'selected' : '' }}>Viúvo</option>
    </select>
</div>

                    <div class="col-md-6">
                        <label>Altura</label>
                        <input name="altura" value="{{ old('altura', $cliente->altura) }}"
                             class="form-control">
                    </div>

                    <div class="col-md-6">

    <label>Data Nascimento</label>

    <input type="date"
           name="data_nascimento"
           value="{{ old('data_nascimento', $cliente->data_nascimento ? $cliente->data_nascimento->format('Y-m-d') : '') }}"
           class="form-control">

</div>

                    <div class="col-md-6 mt-3">

    <label>Plano</label>

    <select name="plano_id" class="form-control">

        <option value="">Selecione</option>

        @foreach($planos as $plano)

            <option value="{{ $plano->id }}"
                {{ $cliente->plano_id == $plano->id ? 'selected' : '' }}>

                {{ $plano->nome }} - R$ {{ $plano->valor }}

            </option>

        @endforeach

    </select>

</div>

                    <div class="col-md-6">
                        <label>Origem</label>
                        <input name="origem" value="{{ old('origem', $cliente->origem) }}"
                             class="form-control">
                    </div>

     <div class="col-md-6 mt-3">

    <label>Status</label>

    <select name="status" class="form-control">

        <option value="ativo"
            {{ old('status', $cliente->status) == 'ativo' ? 'selected' : '' }}>
            Ativo
        </option>

        <option value="inativo"
            {{ old('status', $cliente->status) == 'inativo' ? 'selected' : '' }}>
            Inativo
        </option>

        <option value="bloqueado"
            {{ old('status', $cliente->status) == 'bloqueado' ? 'selected' : '' }}>
            Bloqueado
        </option>

       

       

    </select>

</div>

<div class="col-md-12 mt-3">

    <label>Observações</label>

    <textarea name="observacoes"
              rows="4"
              class="form-control">{{ old('observacoes', $cliente->observacoes) }}</textarea>

</div>

                </div>

                <div class="col-md-6">
                    <a href="{{ route('clientes.index') }}"
                        class="btn btn-primary mt-4">
                        Cancelar
                    </a>

                    <button class="btn btn-success mt-4">
                        Atualizar
                    </button>
                </div>

            </form>

        @stop