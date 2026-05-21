@extends('adminlte::page')

@section('title','Contas a Receber')

@section('content')

<div class="card">

    <div class="card-header">

        <h3>

            Contas a Receber

        </h3>

    </div>

    <div class="card-body">

        <table class="table table-bordered">

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
                    <th>Ações</th>

                </tr>

            </thead>

            <tbody>

                @foreach($financeiro as $item)

                <tr>

                    <td>

                        {{ $item['cliente'] }}

                    </td>

                    <td>

                        R$
                        {{ number_format(
                            $item['valor'],
                            2,
                            ',',
                            '.'
                        ) }}

                    </td>

                    <td>

                        R$
                        {{ number_format(
                            $item['pago'],
                            2,
                            ',',
                            '.'
                        ) }}

                    </td>

                    <td>

                        R$
                        {{ number_format(
                            $item['saldo'],
                            2,
                            ',',
                            '.'
                        ) }}

                    </td>

                    <td>

                        {{ $item['vencimento']->format('d-m-Y') }}

                    </td>

                    <td>

                        @if(
                            $item['status']
                            ==
                            'quitado'
                        )

                        <span class="badge badge-success">

                            Quitado

                        </span>

                        @elseif(
                            $item['status']
                            ==
                            'parcial'
                        )

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

"Olá {$item['cliente']}

Sua renovação SpinMove está pendente.

Saldo:
R$ ".number_format(
$item['saldo'],
2,
',',
'.'
)."

Após pagamento envie comprovante."

);

$link =
"https://wa.me/55{$numero}?text={$mensagem}";

@endphp

<a
href="{{ $link }}"
target="_blank"
class="btn btn-success btn-sm"
>

WhatsApp

</a>

</td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@stop