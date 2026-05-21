@extends('adminlte::page')

@section('title', 'Vendas')

@section('content_header')
    <h1>Histórico de Vendas</h1>
@stop

@section('content')

<div class="card">

    <div class="card-body">

        <table class="table table-bordered table-hover">

            <thead>

                <tr>
                    <th>Bike</th>
                    <th>Marca</th>
                    <th>Cliente</th>
                    <th>Valor</th>
                    <th>Data</th>
                    <th>Observações</th>
                </tr>

            </thead>

            <tbody>

                @forelse($vendas as $venda)

                    <tr>

                        <td>
                            {{ $venda->bike->modelo }}
                        </td>

                        <td>
                            {{ $venda->bike->marca }}
                        </td>

                        <td>
                            {{ $venda->cliente ?? '-' }}
                        </td>

                        <td>
                            R$ {{ number_format($venda->valor, 2, ',', '.') }}
                        </td>

                        <td>
                            {{ $venda->data_venda->format('d/m/Y H:i') }}
                        </td>

                        <td>
                            {{ $venda->observacoes ?? '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            Nenhuma venda encontrada.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@stop