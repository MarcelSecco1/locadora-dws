<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocacaoRequest;
use App\Models\Locacao;
use App\Models\Veiculo;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LocacaoController extends Controller
{
    public function index(): View
    {
        return view('locacoes.index', [
            'locacoes' => Locacao::query()->with('veiculo')->latest()->paginate(8),
        ]);
    }

    public function show(Locacao $locacao): View
    {
        $locacao->load('veiculo');

        return view('locacoes.show', compact('locacao'));
    }

    public function create(): View
    {
        return view('locacoes.create', [
            'locacao' => new Locacao(),
            'veiculos' => Veiculo::query()
                ->with('locacoes')
                ->where('status', '!=', 'manutencao')
                ->orderBy('modelo')
                ->get(),
        ]);
    }

    public function store(LocacaoRequest $request): RedirectResponse
    {
        $locacao = Locacao::create($request->validated());

        return redirect()
            ->route('locacoes.show', $locacao)
            ->with('success', 'Locação cadastrada com sucesso.');
    }

    public function edit(Locacao $locacao): View
    {
        return view('locacoes.edit', [
            'locacao' => $locacao,
            'veiculos' => Veiculo::query()
                ->with('locacoes')
                ->where(function ($query) use ($locacao) {
                    $query
                        ->where('status', '!=', 'manutencao')
                        ->orWhere('id', $locacao->veiculo_id);
                })
                ->orderBy('modelo')
                ->get(),
        ]);
    }

    public function update(LocacaoRequest $request, Locacao $locacao): RedirectResponse
    {
        $locacao->update($request->validated());

        return redirect()
            ->route('locacoes.show', $locacao)
            ->with('success', 'Locação atualizada com sucesso.');
    }

    public function destroy(Locacao $locacao): RedirectResponse
    {
        $locacao->delete();

        return redirect()
            ->route('locacoes.index')
            ->with('success', 'Locação removida com sucesso.');
    }
}
