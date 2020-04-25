<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Serie;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        $series = Serie::query()
            ->orderBy('nome')
            ->get();

        $mensagem = $request->session()->get('mensagem');

        return view('series.index', compact('series', 'mensagem'));
    }

    public function create(Request $request)
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request)
    {
        $nome = $request->get('nome');
        $qtdTemporadas = $request->get('qtd_temporadas');
        $epPorTemporada = $request->get('ep_por_temporada');

        $serie = Serie::create(['nome' => $nome]);

        for ($i = 1; $i <= $qtdTemporadas; $i++) {
            $temporada = $serie->temporadas()->create(['numero' => $i]);
            for ($j = 1; $j <= $epPorTemporada; $j++) {
                $temporada->episodios()->create(['numero' => $j]);
            }
        }

        $request->session()
            ->flash(
                'mensagem',
                "Seria com id {$serie->id}, suas temporadas e episódios criados com sucesso: {$serie->nome}");

        return redirect()->route('listar_series');
    }

    public function destroy(Request $request)
    {
        Serie::destroy($request->id);

        $request->session()
            ->flash(
                'mensagem',
                "Seria removida com sucesso");

        return redirect()->route('listar_series');
    }
}
