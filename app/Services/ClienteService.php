<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Plano;
use App\Models\Conversa;
use App\Models\Notification;
use Carbon\Carbon;
use App\Models\ClienteHistorico;  
use Illuminate\Validation\ValidationException;  
use Jenssegers\Agent\Agent;

class ClienteService
{
    public function criar(array $data)
    {
                date_default_timezone_set('America/Sao_Paulo');
$cpf = preg_replace(
    '/\D/',
    '',
    $data['cpf'] ?? ''
);

if (!$this->validarCpf($cpf)) {

    throw ValidationException::withMessages([

        'cpf' => 'CPF inválido.'

    ]);

}
$cep = preg_replace(
    '/\D/',
    '',
    $data['cep'] ?? ''
);

if (strlen($cep) != 8) {

    throw new \Exception(
        'CEP inválido.'
    );

}

$data['telefone'] = preg_replace('/\D/', '', $data['telefone']);


$clienteExistente = Cliente::where(
    'cpf',
    $cpf
)->first();
        
    $data['cpf'] = $cpf;

       if ($clienteExistente) {

    throw ValidationException::withMessages([

        'cpf' => 'Já existe um cliente cadastrado com este CPF.'

    ]);



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
        $data['aceite_contrato'] =  $data['aceite'] ?? false;
       $agent = new Agent();
$dispositivo = $agent->isDesktop()
    ? 'Desktop'
    : ($agent->device() ?: 'Desconhecido');

$data['aceite_detalhes'] = json_encode([

    'ip' => request()->ip(),

    'browser' => $agent->browser(),

    'platform' => $agent->platform(),

    'device' => $dispositivo,

    'url' => request()->fullUrl(),

    'aceito_em' => now()->format('Y-m-d H:i:s'),

]);

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
            $cliente->uuid,

        'lida' => false,

    ]);

}
    

    

        return $cliente;
    }


    private function validarCpf($cpf): bool
{
    $cpf = preg_replace('/\D/', '', $cpf);

    if (strlen($cpf) != 11) {
        return false;
    }

    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    for ($t = 9; $t < 11; $t++) {

        for ($d = 0, $c = 0; $c < $t; $c++) {

            $d += $cpf[$c] * (($t + 1) - $c);

        }

        $d = ((10 * $d) % 11) % 10;

        if ($cpf[$c] != $d) {
            return false;
        }
    }

    return true;
}
}
