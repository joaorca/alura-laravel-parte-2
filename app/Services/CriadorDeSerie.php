<?php

namespace App\Services;

use App\Serie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CriadorDeSerie
{
    public function criarSerie(
        string $nome,
        int $qtdTemporadas,
        int $epPorTemporada
    ): Serie
    {
        DB::beginTransaction();
        $serie = Serie::create(['nome' => $nome]);
        $this->criarTemporadas($serie, $qtdTemporadas, $epPorTemporada);
        DB::commit();

        return $serie;
    }

    public function criarTemporadas(Serie $serie, int $qtdTemporadas, int $epPorTemporada)
    {
        for ($i = 1; $i <= $qtdTemporadas; $i++) {
            $temporada = $serie->temporadas()->create(['numero' => $i]);
            $this->criarEpisodios($temporada, $epPorTemporada);
        }
    }

    public function criarEpisodios(Model $temporada, int $epPorTemporada)
    {
        for ($j = 1; $j <= $epPorTemporada; $j++) {
            $temporada->episodios()->create(['numero' => $j]);
        }
    }
}
