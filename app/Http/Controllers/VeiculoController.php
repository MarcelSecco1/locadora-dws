<?php

namespace App\Http\Controllers;

use App\Http\Requests\VeiculoRequest;
use App\Models\Veiculo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class VeiculoController extends Controller
{
    public function index(): View
    {
        return view('veiculos.index', [
            'veiculos' => Veiculo::query()->latest()->paginate(8),
        ]);
    }

    public function show(Veiculo $veiculo): View
    {
        $veiculo->load(['locacoes' => fn ($query) => $query->latest()]);

        return view('veiculos.show', compact('veiculo'));
    }

    public function create(): View
    {
        return view('veiculos.create', [
            'statusOptions' => $this->statusOptions(),
        ]);
    }

    public function store(VeiculoRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['imagem'] = $request->file('imagem')->store('veiculos', 'public');

        $veiculo = Veiculo::create($data);

        return redirect()
            ->route('veiculos.show', $veiculo)
            ->with('success', 'Veículo cadastrado com sucesso.');
    }

    public function edit(Veiculo $veiculo): View
    {
        return view('veiculos.edit', [
            'veiculo' => $veiculo,
            'statusOptions' => $this->statusOptions(),
        ]);
    }

    public function update(VeiculoRequest $request, Veiculo $veiculo): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('imagem')) {
            if ($veiculo->imagem) {
                Storage::disk('public')->delete($veiculo->imagem);
            }

            $data['imagem'] = $request->file('imagem')->store('veiculos', 'public');
        } else {
            unset($data['imagem']);
        }

        $veiculo->update($data);

        return redirect()
            ->route('veiculos.show', $veiculo)
            ->with('success', 'Veículo atualizado com sucesso.');
    }

    public function destroy(Veiculo $veiculo): RedirectResponse
    {
        if ($veiculo->imagem) {
            Storage::disk('public')->delete($veiculo->imagem);
        }

        $veiculo->delete();

        return redirect()
            ->route('veiculos.index')
            ->with('success', 'Veículo removido com sucesso.');
    }

    private function statusOptions(): array
    {
        return [
            'disponivel' => 'Disponível',
            'alugado' => 'Alugado',
            'manutencao' => 'Manutenção',
        ];
    }
}
