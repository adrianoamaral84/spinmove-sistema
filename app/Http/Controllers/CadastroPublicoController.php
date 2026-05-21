<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Plano;
use Illuminate\Http\Request;

class CadastroPublicoController extends Controller{

    public function create()
    {

        $planos = Plano::all();

        return view(

            'public.cadastro-cliente',

            compact(

                'planos'

            )

        );

    }


    public function store(
        Request $request
    )
    {

        Cliente::create([

            'nome' => $request->nome,

            'telefone' => $request->telefone,

            'cpf' => $request->cpf,

            'email' => $request->email,

            'data_nascimento' =>
                $request->data_nascimento,

            'altura' =>
                $request->altura,

            'endereco' =>
                $request->endereco,

            'bairro' =>
                $request->bairro,

            'profissao' =>
                $request->profissao,

            'estado_civil' =>
                $request->estado_civil,

            'origem' =>
                'Cadastro Online',

            'plano_id' =>
                $request->plano_id,

            'status' =>
                'ativo',

            'observacoes' =>
                'Cadastro realizado pelo cliente'

        ]);


        return redirect()

            ->route(

                'cadastro.publico'

            )

            ->with(

                'success',

                'Cadastro enviado com sucesso!'

            );

    }

}
