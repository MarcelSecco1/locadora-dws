@php
    $locacaoAtual = $locacao ?? null;
@endphp

<div class="grid gap-6 lg:grid-cols-2">
    <label class="space-y-2 lg:col-span-2">
        <span class="text-sm font-semibold text-slate-200">Cliente</span>
        <x-text-input type="text" name="cliente" value="{{ old('cliente', $locacaoAtual->cliente ?? '') }}" placeholder="Nome do cliente" />
        @error('cliente') <p class="text-sm text-rose-300">{{ $message }}</p> @enderror
    </label>

    <label class="space-y-2 lg:col-span-2">
        <span class="text-sm font-semibold text-slate-200">Veículo</span>
        <x-select-input name="veiculo_id">
            <option value="">Selecione um veículo</option>
            @foreach ($veiculos as $veiculoItem)
                <option value="{{ $veiculoItem->id }}" @selected((string) old('veiculo_id', $locacaoAtual->veiculo_id ?? '') === (string) $veiculoItem->id)>
                    {{ $veiculoItem->modelo }} - {{ $veiculoItem->placa }} ({{ $veiculoItem->status_hoje_label }})
                </option>
            @endforeach
        </x-select-input>
        @error('veiculo_id') <p class="text-sm text-rose-300">{{ $message }}</p> @enderror
    </label>

    <label class="space-y-2">
        <span class="text-sm font-semibold text-slate-200">Data de retirada</span>
        <x-text-input type="date" name="data_retirada" value="{{ old('data_retirada', optional($locacaoAtual?->data_retirada)->format('Y-m-d')) }}" />
        @error('data_retirada') <p class="text-sm text-rose-300">{{ $message }}</p> @enderror
    </label>

    <label class="space-y-2">
        <span class="text-sm font-semibold text-slate-200">Data de devolução</span>
        <x-text-input type="date" name="data_devolucao" value="{{ old('data_devolucao', optional($locacaoAtual?->data_devolucao)->format('Y-m-d')) }}" />
        @error('data_devolucao') <p class="text-sm text-rose-300">{{ $message }}</p> @enderror
    </label>
</div>
