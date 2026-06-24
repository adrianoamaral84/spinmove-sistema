<?php

namespace App\Services;

use App\Models\ClienteHistorico;

class HistoricoService
{
    public static function registrar(
        int $clienteId,
        string $evento,
        ?string $descricao = null
    ): void {

        ClienteHistorico::create([
            'cliente_id' => $clienteId,
            'evento' => $evento,
            'descricao' => $descricao,
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
        ]);

    }
}