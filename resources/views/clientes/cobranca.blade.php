@extends('adminlte::page')

@section('title', 'Cobrança')

@section('content_header')
    <h1>Clientes para Cobrança</h1>
@stop

@section('content')

<table class="table table-bordered">

    <thead>
        <tr>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Status</th>
            <th>Ação</th>
        </tr>
    </thead>

    <tbody>

    @foreach($clientes as $cliente)

        @php
            $telefone = preg_replace('/\D/', '', $cliente->telefone);

            $mensagem = match($cliente->status) {
                'atrasado' => "Olá {$cliente->nome}, seu plano venceu e está em atraso. Regularize para continuar com a bike 🚴‍♂️",
                'devendo' => "Olá {$cliente->nome}, falta concluir o pagamento do seu plano. Posso te ajudar? 😊",
            };
        @endphp

        <tr>
            <td>{{ $cliente->nome }}</td>
            <td>{{ $cliente->telefone }}</td>
            <td>{{ $cliente->status }}</td>

            <td>
                <a href="https://wa.me/55{{ $telefone }}?text={{ urlencode($mensagem) }}"
                   target="_blank"
                   class="btn btn-success btn-sm">

                   Cobrar no WhatsApp
                </a>
            </td>
            @php
$totalPago = $cliente->pagamentos->where('usado', false)->sum('valor');
$valorPlano = $cliente->plano->valor ?? 0;
$falta = $valorPlano - $totalPago;
@endphp

<td>R$ {{ max($falta, 0) }}</td>
        </tr>

    @endforeach

    </tbody>

</table>

@stop