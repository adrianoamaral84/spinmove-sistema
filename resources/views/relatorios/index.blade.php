@extends('adminlte::page')

@section('title', 'Relatórios')
@section('css')
<link rel="stylesheet" href="{{ asset('spinmove/css/spinmove.css') }}">
@stop


@section('content_header')

<div class="mb-4">

    <h1 class="mb-1">
        Relatórios Gerenciais
    </h1>

    <small class="text-muted">
        Indicadores da operação SpinMove
    </small>

</div>

@stop



@section('content')


<div class="card">


    <div class="card-body p-0">


        <div class="p-3">


            <div class="d-flex align-items-center">


                <i class="fas fa-chart-line text-primary mr-2"></i>


                <h5 class="mb-0">

                    Visão Geral

                </h5>


            </div>



            <small class="text-muted">

                Acompanhe os principais indicadores da operação.

            </small>



        </div>





        <div class="p-3">


            <div class="row">


    <div class="col-md-3">

        <div class="card dashboard-card">

            <div class="card-body text-center">


                <div class="dashboard-icon mx-auto mb-2 icon-blue">

                    <i class="fas fa-users"></i>

                </div>


                <h3>

                    {{ $clientes }}

                </h3>


                <small class="text-muted">

                    Total Clientes

                </small>


            </div>


            <div class="dashboard-line line-blue"></div>


        </div>

    </div>




    <div class="col-md-3">

        <div class="card dashboard-card">

            <div class="card-body text-center">


                <div class="dashboard-icon mx-auto mb-2 icon-orange">

                    <i class="fas fa-bicycle"></i>

                </div>


                <h3>

                    {{ $bikes }}

                </h3>


                <small class="text-muted">

                    Total Bikes

                </small>


            </div>


            <div class="dashboard-line line-orange"></div>


        </div>

    </div>





    <div class="col-md-3">

        <div class="card dashboard-card">

            <div class="card-body text-center">


                <div class="dashboard-icon mx-auto mb-2 icon-green">

                    <i class="fas fa-route"></i>

                </div>


                <h3>

                    {{ $locacoesAtivas }}

                </h3>


                <small class="text-muted">

                    Locações Ativas

                </small>


            </div>


            <div class="dashboard-line line-green"></div>


        </div>

    </div>






    <div class="col-md-3">

        <div class="card dashboard-card">

            <div class="card-body text-center">


                <div class="dashboard-icon mx-auto mb-2 icon-purple">

                    <i class="fas fa-dollar-sign"></i>

                </div>


                <h3>

                    R$ {{ number_format(
                        $receitaMes,
                        2,
                        ',',
                        '.'
                    ) }}

                </h3>


                <small class="text-muted">

                    Receita do Mês

                </small>


            </div>


            <div class="dashboard-line line-purple"></div>


        </div>

    </div>


</div>





           


        </div>



    </div>


</div>



@stop