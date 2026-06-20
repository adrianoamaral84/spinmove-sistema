@extends('adminlte::page')

@section('title','Contas a Receber')


@section('content_header')

<div class="mb-4">

    <h1 class="mb-1">
        Contas a Receber
    </h1>

    <small class="text-muted">
        Controle das mensalidades e renovações da SpinMove
    </small>

</div>

@stop



@section('content')


<div class="card">


    <div class="card-body p-0">


        <div class="p-3">


            <div class="d-flex align-items-center">

                <i class="fas fa-file-invoice-dollar text-primary mr-2"></i>


                <h5 class="mb-0">

                    Financeiro

                </h5>


            </div>


            <small class="text-muted">

                Acompanhe pagamentos, saldos pendentes e cobranças dos clientes

            </small>


        </div>



        <div class="table-responsive">


            <table class="table table-hover mb-0">


                <thead>


                    <tr>

                        <th>
                            Cliente
                        </th>

                        <th>
                            Cobrança
                        </th>

                        <th>
                            Pago
                        </th>

                        <th>
                            Saldo
                        </th>

                        <th>
                            Vencimento
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Ações
                        </th>


                    </tr>


                </thead>



                <tbody>



                @forelse($financeiro as $item)



                <tr>



                    <td>

                        <strong>

                            {{ $item['cliente'] }}

                        </strong>


                    </td>




                    <td>

                        R$ {{ number_format(
                            $item['valor'],
                            2,
                            ',',
                            '.'
                        ) }}


                    </td>




                    <td>


                        <span class="font-weight-bold text-success">


                            R$ {{ number_format(
                                $item['pago'],
                                2,
                                ',',
                                '.'
                            ) }}


                        </span>


                    </td>




                    <td>


                        <span class="font-weight-bold text-danger">


                            R$ {{ number_format(
                                $item['saldo'],
                                2,
                                ',',
                                '.'
                            ) }}


                        </span>


                    </td>




                    <td>


                        {{ $item['vencimento']->format('d/m/Y') }}


                    </td>




                    <td>



                    @if($item['status']=='quitado')


                        <span class="badge badge-success">

                            Quitado

                        </span>



                    @elseif($item['status']=='parcial')


                        <span class="badge badge-warning">

                            Parcial

                        </span>



                    @else


                        <span class="badge badge-danger">

                            Pendente

                        </span>



                    @endif



                    </td>





                    <td>



@php

$numero = preg_replace(
'/[^0-9]/',
'',
$item['telefone']
);


$mensagem =
urlencode(

"Olá {$item['cliente']} 👋

Sua renovação SpinMove está pendente.

Saldo:
R$ ".number_format(
$item['saldo'],
2,
',',
'.'
)."

Após pagamento envie o comprovante."

);


$link =
"https://wa.me/55{$numero}?text={$mensagem}";


@endphp



<a href="{{ $link }}"
target="_blank"
class="btn btn-success btn-sm">


<i class="fab fa-whatsapp"></i>

WhatsApp


</a>



                    </td>



                </tr>



                @empty



                <tr>

                    <td colspan="7" class="text-center py-5 text-muted">


                        <i class="fas fa-file-invoice fa-2x mb-3 d-block"></i>


                        Nenhuma conta encontrada.


                    </td>


                </tr>



                @endforelse




                </tbody>



            </table>



        </div>



    </div>


</div>



@stop