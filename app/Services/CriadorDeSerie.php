<?php

namespace App\Services;

use App\Serie;

class CriadorDeSerie
{
    public function criarSerie(
        string $nome,
        int $qtdTemporadas,
        int $epPorTemporada
    ): Serie
    {
        $serie = Serie::create(['nome' => $nome]);

        for ($i = 1; $i <= $qtdTemporadas; $i++) {
            $temporada = $serie->temporadas()->create(['numero' => $i]);
            for ($j = 1; $j <= $epPorTemporada; $j++) {
                $temporada->episodios()->create(['numero' => $j]);
            }
        }

        return $serie;
    }
}
