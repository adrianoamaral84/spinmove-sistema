@extends('adminlte::page')

@section('title', 'Cobrança')


@section('content_header')

<div class="mb-4">

    <h1 class="mb-1">
        Clientes para Cobrança
    </h1>

    <small class="text-muted">
        Gerencie cobranças pendentes e atrasadas dos clientes SpinMove
    </small>

</div>

@stop



@section('content')


<div class="card">


    <div class="card-body p-0">



        <div class="p-3">


            <div class="d-flex align-items-center">


                <i class="fas fa-bullhorn text-primary mr-2"></i>


                <h5 class="mb-0">

                    Central de Cobranças

                </h5>


            </div>



            <small class="text-muted">

                Envie mensagens pelo WhatsApp para clientes com pendências financeiras.

            </small>



        </div>





        <div class="table-responsive">


            <table class="table table-hover mb-0">


                <thead>

                    <tr>

                        <th>
                            Nome
                        </th>


                        <th>
                            Telefone
                        </th>


                        <th>
                            Status
                        </th>


                        <th>
                            Valor Pendente
                        </th>


                        <th>
                            Ação
                        </th>


                    </tr>

                </thead>



                <tbody>



                @forelse($clientes as $cliente)



                @php


                $telefone = preg_replace(
                    '/\D/',
                    '',
                    $cliente->telefone
                );



                $mensagem = match($cliente->status) {


                    'atrasado' => 
                    "Olá {$cliente->nome} 👋

Seu plano SpinMove venceu e está em atraso.

Regularize para continuar utilizando sua bike 🚴‍♂️",



                    'devendo' => 
                    "Olá {$cliente->nome} 👋

Identificamos que ainda existe um pagamento pendente do seu plano SpinMove.

Posso te ajudar a regularizar? 😊",


                };



                $totalPago = $cliente->pagamentos
                    ->where('usado', false)
                    ->sum('valor');



                $valorPlano = $cliente->plano->valor ?? 0;



                $falta = max(
                    $valorPlano - $totalPago,
                    0
                );


                @endphp





                <tr>



                    <td>

                        <strong>

                            {{ $cliente->nome }}

                        </strong>


                    </td>




                    <td>

                        {{ $cliente->telefone }}

                    </td>




                    <td>


                        @if($cliente->status == 'atrasado')


                            <span class="badge badge-danger">

                                Atrasado

                            </span>



                        @else


                            <span class="badge badge-warning">

                                Devendo

                            </span>



                        @endif


                    </td>




                    <td>


                        <span class="font-weight-bold text-danger">

                            R$ {{ number_format(
                                $falta,
                                2,
                                ',',
                                '.'
                            ) }}


                        </span>


                    </td>




                    <td>



                        <a href="https://wa.me/55{{ $telefone }}?text={{ urlencode($mensagem) }}"
                           target="_blank"
                           class="btn btn-success btn-sm">


                            <i class="fab fa-whatsapp"></i>

                            Cobrar


                        </a>


                    </td>



                </tr>




                @empty



                <tr>


                    <td colspan="5" class="text-center py-5 text-muted">


                        <i class="fas fa-check-circle fa-2x mb-3 d-block"></i>


                        Nenhum cliente pendente para cobrança.


                    </td>


                </tr>



                @endforelse



                </tbody>



            </table>



        </div>



    </div>


</div>



@stop