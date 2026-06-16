@extends('adminlte::page')

@section('title', 'Nova Locação')

@section('content_header')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1 class="mb-1">
            Nova Locação
        </h1>

        <small class="text-muted">
            Cadastre uma nova locação de bike
        </small>

    </div>

</div>

@stop

@section('content')

<div class="card">

    <div class="card-header spinmove-header">

        <h5 class="mb-0">

            <i class="fas fa-bicycle mr-2"></i>

            Dados da Locação

        </h5>

    </div>

    <div class="card-body">

        <form action="{{ route('locacoes.store') }}"
              method="POST">

            @csrf

            <div class="row">

    <div class="col-md-6">

        <div class="form-group">

            <label>Cliente</label>

            <select
                name="cliente_id"
                class="form-control select2"
                required>

                <option value="">Selecione</option>

                @foreach($clientes as $cliente)

                    <option value="{{ $cliente->id }}">
                        {{ $cliente->nome }}
                    </option>

                @endforeach

            </select>

        </div>

    </div>

    <div class="col-md-6">

        <div class="form-group">

            <label>Bike</label>

            <select
                name="bike_id"
                class="form-control select2-bike"
                required>

                <option value="">Selecione</option>

                @foreach($bikes as $bike)

                    <option value="{{ $bike->id }}">
                        {{ $bike->codigo }} - {{ $bike->modelo }}
                    </option>

                @endforeach

            </select>

        </div>

    </div>

</div>

            <div class="form-group">

    <label>Plano</label>

    <select
        name="plano_id"
        class="form-control"
        required>

        <option value="">
            Selecione o plano
        </option>

        @foreach($planos as $plano)

            <option value="{{ $plano->id }}">

                {{ $plano->nome }}
                - R$ {{ number_format($plano->valor,2,',','.') }}

            </option>

        @endforeach

    </select>

</div>

        

            
            <div class="form-group">

    <label>Observações</label>

    <textarea
        name="observacoes"
        rows="4"
        class="form-control"
        placeholder="Informações adicionais da locação..."></textarea>

</div>

            <div class="d-flex justify-content">

    <a href="{{ route('locacoes.index') }}"
       class="btn btn-light mr-2">

        Cancelar

    </a>

    <button class="btn btn-success">

        <i class="fas fa-save mr-1"></i>

        Salvar Locação

    </button>

</div>

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
<script>
    $(function(){

    $('.select2').select2({
        placeholder:'Pesquisar cliente',
        width:'100%'
    });

    $('.select2-bike').select2({
        placeholder:'Pesquisar bike',
        width:'100%'
    });

});
</script>
@stop