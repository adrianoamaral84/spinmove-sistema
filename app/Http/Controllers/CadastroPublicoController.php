<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Plano;
use Illuminate\Http\Request;
use App\Services\ClienteService;
use App\Models\ClienteHistorico;
use App\Services\HistoricoService;

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
        'cpf' => 'required',
        'email' => 'required',
        'data_nascimento' => 'required',
        'altura' => 'required',
        'endereco' => 'required',
        'bairro' => 'required',
        'profissao' => 'required',
        'estado_civil' => 'required',
        'origem' => 'required',
        'plano_id' => 'required|exists:planos,id',
        'cep' => 'required|string|size:9|regex:/^\d{5}-\d{3}$/',
        'numero' => 'required|string|max:20',
        'cidade' => 'required|string|max:100',
        'aceite' => 'required',
        'estado' => 'nullable|string|size:2',
    ],[
    'nome.required' => 'O nome é obrigatório.',
    'telefone.required' => 'Informe o telefone.',
    'cpf.required' => 'Informe o CPF.',
    'email.required' => 'Informe o E-mail.',
    'data_nascimento.required' => 'Informe a data de nascimento.',
    'altura.required' => 'Informe a altura.',
    'endereco.required' => 'Informe o endereco.',
    'bairro.required' => 'Informe o bairro.',
    'profissao.required' => 'Informe a profissao.',
    'estado_civil.required' => 'Informe o estado civil.',
    'origem.required' => 'Informe o onde nos conheceu.',
    'plano_id.required' => 'Selecione um plano.',
    'plano_id.exists' => 'O plano selecionado não existe.',
    'cep.required' => 'O CEP é obrigatório.',
    'numero.required' => 'O número é obrigatório.',
    'cidade.required' => 'A cidade é obrigatória.',
    'aceite.required' => 'O Termo precisa ser aceito',
    'estado.string' => 'O estado deve ser uma string.',
    'estado.size' => 'O estado deve ter 2 caracteres.',
]);

    
        
    $cliente = $service->criar($data);
    
    HistoricoService::registrar(
    $cliente->id,
    'Cadastro realizado',
    'Cadastro enviado pelo formulário público'
);
   HistoricoService::registrar(
    $cliente->id,
    'Termo aceito',
    'Cliente aceitou os termos da locação'
);
    
    //return redirect()->back()->with('success', 'Cadastro realizado com sucesso!');
    return view('public.sucesso');
}
}
