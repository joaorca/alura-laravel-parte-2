<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Serie;
use App\Services\CriadorDeSerie;
use App\Services\RemovedorDeSerie;
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

    public function store(
        SeriesFormRequest $request,
        CriadorDeSerie $criadorDeSerie
    ) {
        $serie = $criadorDeSerie->criarSerie(
            $request->nome,
            (int)$request->qtd_temporadas,
            (int)$request->ep_por_temporada
        );

        $request->session()
            ->flash(
                'mensagem',
                "Seria com id {$serie->id}, suas temporadas e episódios criados
                com sucesso: {$serie->nome}"
            );

        return redirect()->route('listar_series');
    }

    public function destroy(
        Request $request,
        RemovedorDeSerie $removedorDeSerie
    ) {
        $nomeSerie = $removedorDeSerie->removerSerie((int)$request->id);

        $request->session()
            ->flash(
                'mensagem',
                "Seria $nomeSerie removida com sucesso"
            );

        return redirect()->route('listar_series');
    }

    public function editaNome(int $id, Request $request)
    {
        $novoNome = $request->nome;
        $serie = Serie::find($id);
        $serie->nome = $novoNome;
        $serie->save();
    }
}
