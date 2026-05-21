<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\Cliente;
use App\Models\Locacao;
use App\Models\Pagamento;
use App\Models\LocacaoRenovacao;

class DashboardController extends Controller
{

    public function index()
{

    // OPERAÇÃO

    $totalBikes = Bike::count();

    $bikesAlugadas = Bike::where(
        'status',
        'alugada'
    )->count();

    $bikesDisponiveis = Bike::where(
        'status',
        'disponivel'
    )->count();

    $clientesAtivos = Cliente::count();


    // FINANCEIRO

    $recebidoMes = Pagamento::where(
            'tipo',
            'pagamento'
        )
        ->whereMonth(
            'created_at',
            now()->month
        )
        ->sum('valor');


    $cobrancasPendentes = 0;

    $cobrancas = Pagamento::where(
            'tipo',
            'cobranca'
        )
        ->get();


    foreach ($cobrancas as $cobranca) {

        $totalPago = Pagamento::where(
                'cobranca_id',
                $cobranca->id
            )
            ->where(
                'tipo',
                'pagamento'
            )
            ->sum('valor');

        $saldo = $cobranca->valor - $totalPago;

        if ($saldo > 0) {

            $cobrancasPendentes += $saldo;

        }

    }


    $renovacoesMes =
        LocacaoRenovacao::whereMonth(
            'created_at',
            now()->month
        )->count();


    $atrasados =
        Locacao::where(
            'status',
            'atrasada'
        )->count();



        $vencendo = Locacao::whereDate(
        'data_vencimento',
        '<=',
        now()->addDays(7)
    )
    ->where(
        'status',
        'ativa'
    )
    ->with('cliente')
    ->orderBy('data_vencimento')
    ->get();

    $pendentes = [];

foreach ($cobrancas as $cobranca) {

    $totalPago = Pagamento::where(
            'cobranca_id',
            $cobranca->id
        )
        ->where(
            'tipo',
            'pagamento'
        )
        ->sum('valor');

    $saldo = $cobranca->valor - $totalPago;

    if ($saldo > 0) {

        $pendentes[] = [

            'cliente' =>
                $cobranca->cliente->nome ?? 'Cliente',

            'saldo' => $saldo

        ];

    }

}

    return view(
        'dashboard',
        compact(

            'totalBikes',
            'bikesAlugadas',
            'bikesDisponiveis',
            'clientesAtivos',
            'vencendo',
            'pendentes',
            'recebidoMes',
            'cobrancasPendentes',
            'renovacoesMes',
            'atrasados'

        )
    );

}
}