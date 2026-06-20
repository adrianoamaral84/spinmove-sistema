@extends('adminlte::page')

@section('title', 'Novo Plano')


@section('content_header')

<div class="mb-4">

    <h1 class="mb-1">
        Novo Plano
    </h1>

    <small class="text-muted">
        Cadastre um novo plano de locação SpinMove
    </small>

</div>

@stop



@section('content')


<div class="card">


    <div class="card-body">


        <div class="d-flex align-items-center mb-3">


            <i class="fas fa-tags text-primary mr-2"></i>


            <h5 class="mb-0">

                Dados do Plano

            </h5>


        </div>



        <small class="text-muted d-block mb-4">

            Informe as informações comerciais do plano.

        </small>




        <form method="POST" action="{{ route('planos.store') }}">


            @csrf




            <div class="form-group">


                <label>

                    Nome do Plano

                </label>


                <input 
                    name="nome"
                    class="form-control"
                    placeholder="Ex: Plano Trimestral"
                    value="{{ old('nome') }}"
                >


            </div>




            <div class="form-group">


                <label>

                    Valor

                </label>


                <div class="input-group">


                    <div class="input-group-prepend">

                        <span class="input-group-text">

                            R$

                        </span>

                    </div>


                    <input 
                        name="valor"
                        type="number"
                        step="0.01"
                        class="form-control"
                        placeholder="0,00"
                        value="{{ old('valor') }}"
                    >


                </div>


            </div>




            <div class="form-group">


                <label>

                    Duração do Plano

                </label>


                <div class="input-group">


                    <input 
                        name="duracao_dias"
                        type="number"
                        class="form-control"
                        placeholder="Ex: 90"
                        value="{{ old('duracao_dias') }}"
                    >


                    <div class="input-group-append">

                        <span class="input-group-text">

                            dias

                        </span>

                    </div>


                </div>


            </div>




            <div class="mt-4">


                <button class="btn btn-success">

                    <i class="fas fa-save mr-1"></i>

                    Salvar Plano


                </button>



                <a href="{{ route('planos.index') }}"
                   class="btn btn-secondary ml-2">


                    <i class="fas fa-arrow-left mr-1"></i>

                    Voltar


                </a>


            </div>



        </form>



    </div>


</div>



@stop