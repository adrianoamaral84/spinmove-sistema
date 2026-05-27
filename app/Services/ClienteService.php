<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Plano;
use App\Models\Conversa;
use App\Models\Notification;
use Carbon\Carbon;

class ClienteService
{
    public function criar(array $data)
    {
                date_default_timezone_set('America/Sao_Paulo');
//dd($data);
        // evita duplicado (CPF)
        $cpf = preg_replace(
    '/\D/',
    '',
    $data['cpf'] ?? ''
);

$data['telefone'] = preg_replace('/\D/', '', $data['telefone']);


$clienteExistente = Cliente::where(
    'cpf',
    $cpf
)->first();
        
    $data['cpf'] = $cpf;

        if ($clienteExistente) {
            return $clienteExistente;
        }

        // vencimento automático
        if (!empty($data['plano_id'])) {
            $plano = Plano::find($data['plano_id']);

            if ($plano) {
                //$data['data_vencimento'] = Carbon::today()
                  //  ->addDays($plano->duracao_dias)
                   // ->format('Y-m-d');
            }
        }


        // conversa (caso exista)
        $conversa = Conversa::where('telefone', $data['telefone'] ?? null)->first();
        $data['conversa_id'] = $conversa->id ?? null;
        
        $cliente = Cliente::create($data);
        

       
if ($cliente) {

    Notification::create([

        'titulo' => 'Novo cadastro recebido',

        'mensagem' =>
            'Cliente cadastrado pelo formulário público',

        'nome_cliente' =>
            $cliente->nome,

        'telefone' =>
            $cliente->telefone,

        'plano_id' =>
            $cliente->plano_id,

        'cliente_id' =>
            $cliente->id,

        'lida' => false,

    ]);

}

        return $cliente;
    }
}
