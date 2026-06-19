<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocacaoRequest;
use App\Models\Locacao;
use App\Models\Veiculo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
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
                ->where('status', 'disponivel')
                ->orderBy('modelo')
                ->get(),
        ]);
    }

    public function store(LocacaoRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $veiculo = Veiculo::query()->findOrFail($data['veiculo_id']);

        abort_if($veiculo->status !== 'disponivel', 422, 'Selecione um veículo disponível.');

        $locacao = DB::transaction(function () use ($data) {
            $locacao = Locacao::create($data);

            Veiculo::whereKey($data['veiculo_id'])->update([
                'status' => 'alugado',
            ]);

            return $locacao;
        });

        return redirect()
            ->route('locacoes.show', $locacao)
            ->with('success', 'Locação cadastrada com sucesso.');
    }

    public function edit(Locacao $locacao): View
    {
        return view('locacoes.edit', [
            'locacao' => $locacao,
            'veiculos' => Veiculo::query()
                ->where('status', 'disponivel')
                ->orWhereKey($locacao->veiculo_id)
                ->orderBy('modelo')
                ->get(),
        ]);
    }

    public function update(LocacaoRequest $request, Locacao $locacao): RedirectResponse
    {
        $data = $request->validated();
        $oldVeiculoId = $locacao->veiculo_id;
        $veiculoSelecionado = Veiculo::query()->findOrFail($data['veiculo_id']);

        abort_if($veiculoSelecionado->status !== 'disponivel' && (int) $oldVeiculoId !== (int) $veiculoSelecionado->id, 422, 'Selecione um veículo disponível.');

        DB::transaction(function () use ($locacao, $data, $oldVeiculoId) {
            $locacao->update($data);

            if ((int) $oldVeiculoId !== (int) $data['veiculo_id']) {
                Veiculo::whereKey($oldVeiculoId)->update(['status' => 'disponivel']);
            }

            Veiculo::whereKey($data['veiculo_id'])->update(['status' => 'alugado']);
        });

        return redirect()
            ->route('locacoes.show', $locacao)
            ->with('success', 'Locação atualizada com sucesso.');
    }

    public function destroy(Locacao $locacao): RedirectResponse
    {
        $veiculoId = $locacao->veiculo_id;
        $locacao->delete();

        Veiculo::whereKey($veiculoId)->update(['status' => 'disponivel']);

        return redirect()
            ->route('locacoes.index')
            ->with('success', 'Locação removida com sucesso.');
    }
}
