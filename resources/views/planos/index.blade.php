@extends('adminlte::page')

@section('title', 'Planos')


@section('content_header')

<div class="mb-4">

    <h1 class="mb-1">
        Planos
    </h1>

    <small class="text-muted">
        Gerencie os planos de locação das bikes SpinMove
    </small>

</div>

@stop



@section('content')


<div class="card">


    <div class="card-body p-0">



        <div class="p-3">


            <div class="d-flex align-items-center">


                <i class="fas fa-tags text-primary mr-2"></i>


                <h5 class="mb-0">

                    Planos cadastrados

                </h5>


            </div>



            <small class="text-muted">

                Configure valores e duração dos planos disponíveis para os clientes.

            </small>



        </div>



        <div class="px-3 pb-3">


            <a href="{{ route('planos.create') }}"
               class="btn btn-primary">


                <i class="fas fa-plus mr-1"></i>

                Novo Plano


            </a>


        </div>





        <div class="table-responsive">


            <table class="table table-hover mb-0">


                <thead>


                    <tr>

                        <th>
                            Nome
                        </th>

                        <th>
                            Valor
                        </th>

                        <th>
                            Duração
                        </th>

                        <th>
                            Ações
                        </th>


                    </tr>


                </thead>



                <tbody>



                @forelse($planos as $plano)



                <tr>



                    <td>

                        <strong>

                            {{ $plano->nome }}

                        </strong>


                    </td>



                    <td>


                        <span class="font-weight-bold text-success">


                            R$ {{ number_format(
                                $plano->valor,
                                2,
                                ',',
                                '.'
                            ) }}


                        </span>


                    </td>



                    <td>


                        {{ $plano->duracao_dias }} dias


                    </td>



                    <td>



                        <a href="{{ route('planos.edit', $plano->id) }}"
                           class="btn btn-warning btn-sm">


                            <i class="fas fa-edit"></i>

                            Editar


                        </a>





                        <form action="{{ route('planos.destroy', $plano->id) }}"
                              method="POST"
                              style="display:inline;">


                            @csrf

                            @method('DELETE')



                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Deseja excluir este plano?')">


                                <i class="fas fa-trash"></i>

                                Excluir


                            </button>



                        </form>



                    </td>



                </tr>



                @empty



                <tr>


                    <td colspan="4" class="text-center py-5 text-muted">


                        <i class="fas fa-tags fa-2x mb-3 d-block"></i>


                        Nenhum plano cadastrado.


                    </td>


                </tr>



                @endforelse



                </tbody>



            </table>



        </div>



    </div>


</div>



@stop