<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pagamento;
use App\Models\Cliente;
use Carbon\Carbon;


class PagamentoController extends Controller
{
    
public function store(Request $request)
{
    $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
        'valor' => 'required|numeric',
        'data_pagamento' => 'nullable|date'
    ]);

    $cliente = \App\Models\Cliente::findOrFail($request->cliente_id);

    $dataPagamento = $request->data_pagamento ?? now();

    // 💰 salva pagamento
    \App\Models\Pagamento::create([
        'cliente_id' => $cliente->id,
        'valor' => $request->valor,
        'data_pagamento' => $dataPagamento,
        'forma_pagamento' => $request->forma_pagamento,
        'observacao' => $request->observacao,
        'usado' => false
    ]);

    // 🔥 SOMA APENAS PAGAMENTOS NÃO USADOS
    $totalPago = $cliente->pagamentos()
        ->where('usado', false)
        ->sum('valor');

    $valorPlano = $cliente->plano->valor;

    // 💰 SE QUITOU O PLANO
    if ($totalPago >= $valorPlano) {

        $base = $cliente->data_vencimento && $cliente->data_vencimento > now()
            ? $cliente->data_vencimento
            : $dataPagamento;

        $cliente->data_vencimento = Carbon::parse($base)
            ->addDays($cliente->plano->duracao_dias);

        $cliente->save();

        // 🔥 MARCA PAGAMENTOS COMO USADOS
        $cliente->pagamentos()
            ->where('usado', false)
            ->update(['usado' => true]);
    }

    return back()->with('success', 'Pagamento registrado com sucesso');
}


public function update(Request $request, $id)
{
    $pagamento = \App\Models\Pagamento::findOrFail($id);

    $request->validate([
        'valor' => 'required|numeric',
        'data_pagamento' => 'required|date'
    ]);

    $pagamento->update([
        'valor' => $request->valor,
        'data_pagamento' => $request->data_pagamento,
        'forma_pagamento' => $request->forma_pagamento,
        'observacao' => $request->observacao,
        'usado' => false // 🔥 força recalcular
    ]);

    $this->recalcularCliente($pagamento->cliente_id);

    return back()->with('success', 'Pagamento atualizado');
}

public function destroy($id)
{
    $pagamento = \App\Models\Pagamento::findOrFail($id);
    $clienteId = $pagamento->cliente_id;

    $pagamento->delete();

    $this->recalcularCliente($clienteId);

    return back()->with('success', 'Pagamento excluído');
}
private function recalcularCliente($clienteId)
{
    $cliente = \App\Models\Cliente::with('pagamentos', 'plano')->find($clienteId);

    // 🔄 reset
    $cliente->data_vencimento = null;
    $cliente->save();

    // 🔄 pega pagamentos não usados
    $pagamentos = $cliente->pagamentos()
        ->where('usado', false)
        ->orderBy('data_pagamento')
        ->get();

    $acumulado = 0;

    foreach ($pagamentos as $pagamento) {

        $acumulado += $pagamento->valor;

        if ($acumulado >= $cliente->plano->valor) {

            $base = $cliente->data_vencimento && $cliente->data_vencimento > now()
                ? $cliente->data_vencimento
                : $pagamento->data_pagamento;

            $cliente->data_vencimento = \Carbon\Carbon::parse($base)
                ->addDays($cliente->plano->duracao_dias);

            $cliente->save();

            // marca como usado
            $pagamento->update(['usado' => true]);

            $acumulado = 0; // 🔥 reinicia ciclo
        }
    }
}
}
