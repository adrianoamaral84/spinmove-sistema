<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CRMService;

class WebhookController extends Controller
{
    protected $crm;

    public function __construct(CRMService $crm)
    {
        $this->crm = $crm;
    }

  


    public function receber(Request $request)
{
    
    \Log::info('Webhook recebido', $request->all());

    //$jid = $request->input('sender');
    $jid = $request->input('data.key.participant');
    if (!$jid || !str_contains($jid, '@')) {
    return response()->json(['ignored' => true]);
}
    if (!$jid || str_contains($jid, 'status') || str_contains($jid, 'broadcast')) {
        return response()->json(['ignored' => true]);
    }

    // TELEFONE LIMPO
    $telefone = explode('@', $jid)[0];
    $telefone = preg_replace('/\D/', '', $telefone);

    // NOME
    $nome = $request->input('data.pushName') ?? 'Sem nome';

    // MENSAGEM
    $mensagem = $request->input('data.message.conversation');

    if (!$mensagem) {
        return response()->json(['ignored' => true]);
    }

    // REMETENTE
    $fromMe = $request->input('data.key.fromMe');
    $remetente = $fromMe ? 'empresa' : 'cliente';

    // ENVIA TUDO PRO CRM
    $this->crm->receberMensagem($telefone, $mensagem, $remetente, $nome);

    return response()->json(['status' => 'ok']);
}




    public function receber2(Request $request)
{
    \Log::info('Webhook recebido', $request->all());

    $jid = $request->input('data.key.remoteJid');

    // ignora mensagens inválidas
    if (!$jid || str_contains($jid, 'status') || str_contains($jid, 'broadcast')) {
        return response()->json(['ignored' => true]);
    }

    // limpa telefone
    $telefone = explode('@', $jid)[0];
    $telefone = preg_replace('/\D/', '', $telefone);

    // nome do contato
    $nome = $request->input('data.pushName');

    // mensagem
    $mensagem = $request->input('data.message.conversation');

    // quem enviou
    $fromMe = $request->input('data.key.fromMe');
    $remetente = $fromMe ? 'empresa' : 'cliente';

    // evita mensagem vazia (tipo áudio, imagem, etc)
    if (!$mensagem) {
        return response()->json(['ignored' => true]);
    }

    // envia pro CRM
    $this->crm->receberMensagem($telefone, $mensagem);

    return response()->json(['status' => 'ok']);
    }
    
    
    
    public function receber1(Request $request)
    {
        \Log::info('Webhook recebido', $request->all());
        //dd("ok");
        $telefone = $request->input('data.key.remoteJid');
        $mensagem = $request->input('data.message.conversation')
    ?? $request->input('data.message.extendedTextMessage.text')
    ?? null;
        $fromMe = $request->input('data.key.fromMe');
        
        if (!$telefone || !$mensagem) {
            return response()->json(['ignored' => true]);
        }

        $telefone = explode('@', $telefone)[0];
        try {
    $this->crm->receberMensagem($telefone, $mensagem, $fromMe);
} catch (\Exception $e) {
    return response()->json([
        'erro' => $e->getMessage(),
        'linha' => $e->getLine()
    ]);
}

        return response()->json(['status' => 'ok']);
    }
}