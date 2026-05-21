@extends('adminlte::page')

@section('title', 'Bike')

@section('content')

<div class="card">

    <div class="card-header">

        <h3>

            Bike {{ $bike->modelo }}

        </h3>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-3">

                <strong>Status:</strong>

                <br>

                {{ $bike->status }}

            </div>

            <div class="col-md-3">

                <strong>Valor compra:</strong>

                <br>

                R$
                {{ number_format(
                    $bike->valor_compra,
                    2,
                    ',',
                    '.'
                ) }}

            </div>

            <div class="col-md-3">

                <strong>Valor venda:</strong>

                <br>

                R$
                {{ number_format(
                    $bike->valor_venda,
                    2,
                    ',',
                    '.'
                ) }}

            </div>

        </div>

    </div>

</div>


<div class="card mt-3">

    <div class="card-header">

        <h3>

            Histórico de Locações

        </h3>

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>Cliente</th>

                    <th>Início</th>

                    <th>Vencimento</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

                @forelse($locacoes as $locacao)

                <tr>

                    <td>

                        {{ $locacao->cliente->nome ?? '-' }}

                    </td>

                    <td>

                        {{ date(
                            'd/m/Y',
                            strtotime(
                                $locacao->created_at
                            )
                        ) }}

                    </td>

                    <td>

                        {{ date(
                            'd/m/Y',
                            strtotime(
                                $locacao->data_vencimento
                            )
                        ) }}

                    </td>

                    <td>

                        @if(
                            $locacao->status
                            ==
                            'ativa'
                        )

                        <span class="badge badge-success">

                            Ativa

                        </span>

                        @elseif(
                            $locacao->status
                            ==
                            'aguardando_retirada'
                        )

                        <span class="badge badge-warning">

                            Aguardando Retirada

                        </span>

                        @else

                        <span class="badge badge-secondary">

                            Finalizada

                        </span>

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="4">

                        Nenhuma locação.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@stop