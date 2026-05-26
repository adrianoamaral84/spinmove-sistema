<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Plano;
use Illuminate\Http\Request;
use App\Services\ClienteService;

class CadastroPublicoController extends Controller{

   public function create()
{
    $planos = \App\Models\Plano::whereIn('duracao_dias', [90, 180]) // 3 e 6 meses
        ->get();

    foreach ($planos as $plano) {

        $plano->valor_mensal = $plano->duracao_dias > 0
            ? ($plano->valor / $plano->duracao_dias) * 30
            : PHP_INT_MAX;

        $plano->score = (
            (1 / $plano->valor_mensal) * 70
            + ($plano->duracao_dias / 30) * 30
        );
    }

    $planos = $planos->sortByDesc('score')->values();

    $recomendadoId = $planos->first()->id;

    return view('public/cadastro-cliente', compact('planos', 'recomendadoId'));
}


   

public function store(Request $request, ClienteService $service)
{
            date_default_timezone_set('America/Sao_Paulo');

    $data = $request->validate([
        'nome' => 'required',
        'telefone' => 'required',
        'cpf' => 'nullable',
        'email' => 'nullable',
        'data_nascimento' => 'nullable',
        'altura' => 'nullable',
        'endereco' => 'nullable',
        'bairro' => 'nullable',
        'profissao' => 'nullable',
        'estado_civil' => 'nullable',
        'origem' => 'nullable',
        'plano_id' => 'required|exists:planos,id'
    ]);
        
    $service->criar($data);
    //return redirect()->back()->with('success', 'Cadastro realizado com sucesso!');
    return view('public.sucesso');
}
}
