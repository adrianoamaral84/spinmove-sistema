<?php

namespace App\Http\Controllers;

use App\Models\Pagamento;

class FinanceiroController extends Controller
{

    public function index()
    {

        $cobrancas = Pagamento::where(
                'tipo',
                'cobranca'
            )
            ->latest()
            ->get();


        $financeiro = [];


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


            $saldo =
    $cobranca->valor
    - $totalPago;


if ($saldo <= 0) {
    continue;
}


if ($totalPago > 0) {

    $status = 'parcial';

} else {

    $status = 'pendente';

}

            $financeiro[] = [

                'cliente' =>
                    $cobranca->cliente->nome
                    ?? '-',

                'valor' =>
                    $cobranca->valor,

                'pago' =>
                    $totalPago,

                'saldo' =>
                    $saldo,

                'status' =>
                    $status,

                'vencimento' =>
                    optional(
                        $cobranca->locacao
                    )->data_vencimento,

                'telefone' =>
    $cobranca->cliente->telefone
    ?? '',

                'locacao_id' =>
                    $cobranca->locacao_id

            ];

        }


        return view(

            'financeiro.index',

            compact(
                'financeiro'
            )

        );

    }

}
