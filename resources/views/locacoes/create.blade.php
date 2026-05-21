@extends('adminlte::page')

@section('title', 'Nova Locação')

@section('content_header')
    <h1>Nova Locação</h1>
@stop

@section('content')

<div class="card">

    <div class="card-body">

        <form action="{{ route('locacoes.store') }}"
              method="POST">

            @csrf

            <div class="form-group">

                <label>Cliente</label>

                <select
name="cliente_id"
class="form-control select2"
required
>

                    <option value="">
                        Selecione
                    </option>

                    @foreach($clientes as $cliente)

                        <option value="{{ $cliente->id }}">
                            {{ $cliente->nome }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="form-group">

                <label>Bike</label>

                <select name="bike_id"
                        class="form-control"
                        required>

                    <option value="">
                        Selecione
                    </option>

                    @foreach($bikes as $bike)

                        <option value="{{ $bike->id }}">
                            {{ $bike->codigo }} - {{ $bike->modelo }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="form-group">

    <label>Plano</label>

    <select name="plano_id"
            class="form-control"
            required>

        <option value="">
            Selecione
        </option>

        @foreach($planos as $plano)

            <option value="{{ $plano->id }}">

                {{ $plano->nome }}

                - R$ {{ number_format($plano->valor, 2, ',', '.') }}

            </option>

        @endforeach

    </select>

</div>

        

            
            <div class="form-group">

                <label>Observações</label>

                <textarea name="observacoes"
                          class="form-control"></textarea>

            </div>

            <button class="btn btn-success">

                Salvar Locação

            </button>

        </form>

    </div>

</div>

@stop
@section('css')

<link
href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
rel="stylesheet"
/>

<style>

.select2-container .select2-selection--single{

    height:38px !important;

}

.select2-container--default
.select2-selection--single{

    border:1px solid #ced4da !important;

    border-radius:4px !important;

}

.select2-container--default
.select2-selection--single
.select2-selection__rendered{

    line-height:36px !important;

    padding-left:12px;

}

.select2-container--default
.select2-selection--single
.select2-selection__arrow{

    height:36px !important;

}

.select2{

    width:100% !important;

}

</style>

@stop
@section('js')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$(function(){

    $('.select2').select2({

        placeholder:
            'Pesquisar cliente',

        width:'100%'

    });

});

</script>

@stop