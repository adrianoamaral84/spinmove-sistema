<?php

namespace App\Services;

use App\Models\Lead;

class LeadService
{
    public function salvarOuAtualizar($telefone, $mensagem)
    {
        $lead = Lead::where('telefone', $telefone)->first();

        if (!$lead) {
            $lead = Lead::create([
                'telefone' => $telefone,
                'status_lead' => 'novo',
                'origem' => 'whatsapp',
                'ultima_mensagem' => $mensagem
            ]);
        } else {
            $lead->update([
                'ultima_mensagem' => $mensagem,
                'status_lead' => 'conversando'
            ]);
        }

        return $lead;
    }
}