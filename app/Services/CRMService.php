<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\Conversa;
use App\Models\Mensagem;
use Carbon\Carbon;

class CRMService
{
    public function receberMensagem($telefone, $texto, $remetente, $nome)
{
    // LEAD
    $lead = Lead::updateOrCreate(
        ['telefone' => $telefone],
        [
            'nome' => $nome,
            'ultima_mensagem' => $texto
        ]
    );

    // CONVERSA
    $conversa = Conversa::firstOrCreate(
    ['telefone' => $telefone],
    [
        'nome' => $nome
    ]
);

// 🔥 FORÇA ATUALIZAÇÃO
$conversa->update([
    'nome' => $nome,
    'ultima_mensagem' => $texto,
    'ultima_mensagem_em' => now(),
    'lead_id' => $lead->id
]);

    // MENSAGEM
    Mensagem::create([
        'conversa_id' => $conversa->id,
        'remetente' => $remetente,
        'mensagem' => $texto,
        'enviada_em' => now()
    ]);
}

    
}