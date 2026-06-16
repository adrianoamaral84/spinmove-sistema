<?php

namespace App\Services;

use App\Models\BikeHistorico;

class BikeHistoricoService
{
    public static function registrar(
        int $bikeId,
        string $evento,
        ?string $descricao = null
    ): void {

        BikeHistorico::create([
            'bike_id' => $bikeId,
            'evento' => $evento,
            'descricao' => $descricao,
            'user_id' => auth()->id(),
        ]);

    }
}