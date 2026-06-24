@extends('adminlte::page')

@section('title', 'Editar Plano')


@section('content_header')

<div class="mb-4">

    <h1 class="mb-1">
        Editar Plano
    </h1>

    <small class="text-muted">
        Atualize as informações do plano de locação SpinMove
    </small>

</div>

@stop



@section('content')


<div class="card">


    <div class="card-body">


        <div class="d-flex align-items-center mb-3">


            <i class="fas fa-edit text-primary mr-2"></i>


            <h5 class="mb-0">

                Dados do Plano

            </h5>


        </div>



        <small class="text-muted d-block mb-4">

            Altere os dados abaixo e salve as modificações.

        </small>





        <form method="POST" action="{{ route('planos.update', $plano->id) }}">


            @csrf

            @method('PUT')





            <div class="form-group">


                <label>

                    Nome do Plano

                </label>


                <input 
                    name="nome"
                    value="{{ old('nome', $plano->nome) }}"
                    class="form-control"
                    placeholder="Ex: Plano Trimestral"
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
                        value="{{ old('valor', $plano->valor) }}"
                        type="number"
                        step="0.01"
                        class="form-control"
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
                        value="{{ old('duracao_dias', $plano->duracao_dias) }}"
                        type="number"
                        class="form-control"
                    >



                    <div class="input-group-append">

                        <span class="input-group-text">

                            dias

                        </span>

                    </div>


                </div>



            </div>





            <div class="mt-4">


                <button class="btn btn-primary">


                    <i class="fas fa-save mr-1"></i>

                    Atualizar Plano


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