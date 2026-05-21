<?php

namespace App\Http\Controllers;

use App\Models\Locacao;
use App\Models\Bike;
use Illuminate\Http\Request;
use App\Models\Plano;
use App\Models\Cliente;
use App\Models\LocacaoRenovacao;
use App\Models\Pagamento;

class LocacaoController extends Controller
{
    public function index()
{

date_default_timezone_set('America/Sao_Paulo');
    // Atualiza atrasadas automaticamente
    Locacao::where('status', 'ativa')
        ->whereDate('data_vencimento', '<', now())
        ->update([
            'status' => 'atrasada'
        ]);

    $locacoes = Locacao::with([
    'cliente',
    'bike',
    'plano',
    'renovacoes'
])
    ->orderBy('data_vencimento')
    ->get();

    // KPIs
    $locacoesAtivas = Locacao::where('status', 'ativa')->count();

    $locacoesAtrasadas = Locacao::where('status', 'atrasada')->count();

    $vencemHoje = Locacao::whereDate(
        'data_vencimento',
        today()
    )->count();

    $receitaMensal = Locacao::whereIn('status', [
        'ativa',
        'atrasada'
    ])->sum('valor_mensal');

    return view('locacoes.index', compact(
        'locacoes',
        'locacoesAtivas',
        'locacoesAtrasadas',
        'vencemHoje',
        'receitaMensal'
    ));
}


public function show($id)
{
    date_default_timezone_set('America/Sao_Paulo');
    $locacao = Locacao::with([
        'cliente',
        'bike',
        'plano',
        'renovacoes',
        //'pagamentos'
    ])->findOrFail($id);
$planos = Plano::all();
    return view(
        'locacoes.show',
        compact('locacao','planos')
    );
}


    public function store(Request $request)
{
    date_default_timezone_set('America/Sao_Paulo');
    $bike = Bike::findOrFail($request->bike_id);
    $plano = Plano::findOrFail($request->plano_id);
    // Cria locação
    Locacao::create([

    'bike_id' => $bike->id,

    'cliente_id' => $request->cliente_id,

    'plano_id' => $request->plano_id,

    'valor_mensal' => $valor_mensal = $plano->valor,

   
    'status' => 'aguardando_entrega',

    'observacoes' => $request->observacoes,

]);



    // Atualiza bike
    $bike->status = 'reservada';

    $bike->save();

    return redirect()->back()
        ->with('success', 'Bike alugada com sucesso!');
}

    public function devolver(Locacao $locacao)
{
    date_default_timezone_set('America/Sao_Paulo');
    // Finaliza locação
    $locacao->status = 'finalizada';

    $locacao->save();

    // Libera bike
    $bike = $locacao->bike;

    $bike->status = 'disponivel';

    $bike->save();

    return redirect()->back()
        ->with('success', 'Bike devolvida com sucesso!');
}
public function create()
{
    date_default_timezone_set('America/Sao_Paulo');
    $clientes = Cliente::orderBy('nome')->get();

    $bikes = Bike::where('status', 'disponivel')
        ->where('status_patrimonial', 'ativa')
        ->get();

    $planos = Plano::orderBy('nome')->get();

    return view('locacoes.create', compact(
        'clientes',
        'bikes',
        'planos'
    ));
}

public function renovar(Request $request, Locacao $locacao)
{
    date_default_timezone_set('America/Sao_Paulo');
    $request->validate([

        'plano_id' => 'required|exists:planos,id',

        'data_vencimento' => 'required|date',

    ]);

    // pega novo plano
    $plano = Plano::findOrFail($request->plano_id);

    // salva vencimento antigo
    $dataAnterior = $locacao->data_vencimento;

    // salva histórico
    
    LocacaoRenovacao::create([

        'locacao_id' => $locacao->id,

        'data_anterior' => $dataAnterior,

        'nova_data' => $request->data_vencimento,

        'valor' => $plano->valor,

    ]);
    Pagamento::create([

    'cliente_id' => $locacao->cliente_id,

    'locacao_id' => $locacao->id,

    'valor' => $plano->valor,

    'forma_pagamento' => null,

    'parcelas' => 1,

    'tipo' => 'cobranca',

    'status' => 'pendente',

    'data_pagamento' => null,

    'observacao' => 'Cobrança automática da renovação'

]);
    // atualiza locação
    $locacao->update([

        'plano_id' => $plano->id,

        'valor_mensal' => $plano->valor,

        'data_vencimento' => $request->data_vencimento,

        'status' => 'ativa',

        'observacoes' => $request->observacoes

    ]);

    return redirect()
        ->back()
        ->with('success', 'Locação renovada com sucesso!');
}

public function entregar(Locacao $locacao)
{
    date_default_timezone_set('America/Sao_Paulo');

    $inicio = now();

    $vencimento = now()->addDays(

        $locacao
            ->plano
            ->duracao_dias

    );

    $locacao->update([

        'status' => 'ativa',
        'data_inicio' => $inicio,
        'data_vencimento' => $vencimento
    ]);

    $locacao->bike->update([

        'status' => 'alugada'

    ]);

    // verifica se já existe cobrança inicial
    $existeCobranca = Pagamento::where('locacao_id', $locacao->id)
        ->where('tipo', 'cobranca')
        ->exists();

    // cria cobrança apenas se não existir
    if (!$existeCobranca) {

        Pagamento::create([

            'cliente_id' => $locacao->cliente_id,

            'locacao_id' => $locacao->id,

            'valor' => $locacao->valor_mensal,

            'forma_pagamento' => null,

            'parcelas' => 1,

            'tipo' => 'cobranca',

            'status' => 'pendente',

            'data_pagamento' => null,

            'observacao' => 'Cobrança inicial da locação'

        ]);

    }

    return redirect()
        ->back()
        ->with(
            'success',
            'Bike entregue com sucesso!'
        );
}



public function registrarPagamento(
    Request $request,
    Locacao $locacao
)
{

    $valorRestante = $request->valor;


    $cobrancas = Pagamento::where(
            'locacao_id',
            $locacao->id
        )
        ->where(
            'tipo',
            'cobranca'
        )
        ->orderBy('created_at')
        ->get();


    foreach ($cobrancas as $cobranca) {

        $jaPago = Pagamento::where(
                'cobranca_id',
                $cobranca->id
            )
            ->where(
                'tipo',
                'pagamento'
            )
            ->sum('valor');


        $saldo = $cobranca->valor - $jaPago;


        if ($saldo <= 0) {
            continue;
        }


        if ($valorRestante <= 0) {
            break;
        }


        $valorAplicado = min(
            $saldo,
            $valorRestante
        );


        Pagamento::create([

            'cliente_id' => $locacao->cliente_id,

            'locacao_id' => $locacao->id,

            'cobranca_id' => $cobranca->id,

            'valor' => $valorAplicado,

            'forma_pagamento' =>
                $request->forma_pagamento,

            'parcelas' =>
                $request->parcelas,

            'tipo' => 'pagamento',

            'status' => 'pago',

            'data_pagamento' => now(),

            'observacao' =>
                $request->observacao

        ]);


        $valorRestante -= $valorAplicado;

    }


    return back()->with(
        'success',
        'Pagamento registrado'
    );

}

public function agendarRetirada(
Request $request,
Locacao $locacao
)
{

    $locacao->update([

        'status' =>

        'aguardando_retirada',

        'observacoes' =>

        $request->observacao

    ]);


    return back()

    ->with(

        'success',

        'Retirada agendada'

    );

}

public function finalizarRetirada(
    Request $request,
    Locacao $locacao
)
{

    $locacao->update([

        'status' => 'finalizada',

        'observacoes' =>

            $request->avaria

    ]);


    $locacao
        ->bike
        ->update([

            'status'

            =>

            'disponivel'

        ]);


    if ($request->multa > 0) {

        Pagamento::create([

            'cliente_id' =>

                $locacao->cliente_id,

            'locacao_id' =>

                $locacao->id,

            'valor' =>

                $request->multa,

            'tipo' =>

                'cobranca',

            'status' =>

                'pendente',

            'parcelas' => 1,

            'observacao' =>

                'Multa / avaria: '

                .$request->avaria

        ]);

    }


    return back()

    ->with(

        'success',

        'Retirada finalizada'

    );

}

public function createCliente(
Cliente $cliente
)
{

    $bikes = Bike::where(
        'status',
        'disponivel'
    )->get();

    $planos =
        Plano::all();

    return view(

        'locacoes.create_cliente',

        compact(

            'cliente',

            'bikes',

            'planos'

        )

    );

}

}
