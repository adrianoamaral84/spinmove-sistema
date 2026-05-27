@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">

    <h2 class="mb-4">
        Dashboard SpinMove
    </h2>
    <div class="mb-3">


    

</div>




<div class="card">

<div class="card-header">

<h3>

Últimos cadastros recebidos

</h3>

</div>

<div class="card-body">

@forelse($topNotifications ?? [] as $item)

<div class="border-bottom pb-3 mb-3">

<div class="d-flex justify-content-between">

<div>

<span class="badge badge-success">

NOVO

</span>

<strong>

{{ $item->titulo }}

</strong>

</div>

<small class="text-muted">

{{ $item->created_at->diffForHumans() }}

</small>

</div>


<div class="mt-2">

👤 {{ $item->nome_cliente }}

<br>

📞 {{ $item->telefone }}

<br>

🚴 {{ $item->plano->nome ?? '-' }}

</div>
<div class="mt-3">
<a

href="{{ route(
'clientes.show',
$item->cliente
) }}"

class="
btn
btn-sm
btn-primary">

Abrir cadastro

</a>


<a

href="https://wa.me/55{{ preg_replace('/\D/','',$item->telefone) }}"

target="_blank"

class="
btn
btn-sm
btn-success">

WhatsApp

</a>

</div>
</div>

@empty

<div class="alert alert-light">

Sem notificações

</div>

@endforelse

</div>

</div>
    <div class="row">

        <div class="col-lg-3">

            <div class="small-box bg-info">

                <div class="inner">

                    <h3>{{ $totalBikes }}</h3>

                    <p>Total de Bikes</p>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="small-box bg-success">

                <div class="inner">

                    <h3>{{ $bikesAlugadas }}</h3>

                    <p>Bikes Alugadas</p>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="small-box bg-primary">

                <div class="inner">

                    <h3>{{ $bikesDisponiveis }}</h3>

                    <p>Bikes Disponíveis</p>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="small-box bg-warning">

                <div class="inner">

                    <h3>{{ $clientesAtivos }}</h3>

                    <p>Clientes</p>

                </div>

            </div>

        </div>

    </div>


    <div class="row mt-4">

        <div class="col-lg-3">

            <div class="small-box bg-success">

                <div class="inner">

                    <h3>
                        R$
                        {{ number_format($recebidoMes, 2, ',', '.') }}
                    </h3>

                    <p>Recebido no mês</p>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="small-box bg-danger">

                <div class="inner">

                    <h3>
                        R$
                        {{ number_format($cobrancasPendentes, 2, ',', '.') }}
                    </h3>

                    <p>Pendências</p>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="small-box bg-info">

                <div class="inner">

                    <h3>{{ $renovacoesMes }}</h3>

                    <p>Renovações do mês</p>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="small-box bg-secondary">

                <div class="inner">

                    <h3>{{ $atrasados }}</h3>

                    <p>Inadimplentes</p>

                </div>

            </div>

        </div>

    </div>

</div>


<div class="row mt-4">

    {{-- VENCENDO --}}

    <div class="col-md-6">

        <div class="card">

            <div class="card-header bg-warning">

                <h3 class="card-title">

                    Vencendo em 7 dias

                </h3>

            </div>

            <div class="card-body">

                @forelse($vencendo as $locacao)

                    <div class="mb-3 border-bottom pb-2">

                        <strong>
                            {{ $locacao->cliente->nome }}
                        </strong>

                        <br>

                        Vence em:
                        {{ date('d/m/Y', strtotime($locacao->data_vencimento)) }}

                    </div>

                @empty

                    <p>
                        Nenhuma locação vencendo.
                    </p>

                @endforelse

            </div>

        </div>

    </div>



    {{-- PENDENTES --}}

    <div class="col-md-6">

        <div class="card">

            <div class="card-header bg-danger">

                <h3 class="card-title">

                    Pendências Financeiras

                </h3>

            </div>

            <div class="card-body">

                @forelse($pendentes as $pendente)

                    <div class="mb-3 border-bottom pb-2">

                        <strong>
                            {{ $pendente['cliente'] }}
                        </strong>

                        <br>

                        Saldo:
                        <strong>

                            R$
                            {{ number_format($pendente['saldo'],2,',','.') }}

                        </strong>

                    </div>

                @empty

                    <p>
                        Nenhuma pendência.
                    </p>

                @endforelse

            </div>

        </div>

    </div>

</div>

@stop