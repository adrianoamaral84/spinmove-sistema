@extends('adminlte::page')

@section('title', 'Vendas')

@section('content_header')

<div class="section-block">

    <div class="d-flex align-items-center">

        

        <h3 class="mb-0">
            Histórico de Vendas
        </h3>

    </div>

    <small class="text-muted">
        Todas as bikes vendidas pela SpinMove, com informações do cliente, valor da venda e data da negociação.
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
                    Vendas Registradas
                </h5>

            </div>

            <small class="text-muted">
                Histórico completo das vendas realizadas
            </small>

        </div>

        <div class="table-responsive">

            <table class="table table-hover mb-0">

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
                            <strong>
                                {{ $venda->bike->modelo }}
                            </strong>
                        </td>

                        <td>
                            {{ $venda->bike->marca }}
                        </td>

                        <td>
                            {{ $venda->cliente ?? '-' }}
                        </td>

                        <td>

                            <span class="font-weight-bold text-success">

                                R$ {{ number_format($venda->valor, 2, ',', '.') }}

                            </span>

                        </td>

                        <td>
                            {{ $venda->data_venda->format('d/m/Y H:i') }}
                        </td>

                        <td>

                            <small class="text-muted">

                                {{ Str::limit($venda->observacoes, 40) }}

                            </small>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="text-center py-5 text-muted">

                            <i class="fas fa-shopping-cart fa-2x mb-3 d-block"></i>

                            Nenhuma venda encontrada.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@stop