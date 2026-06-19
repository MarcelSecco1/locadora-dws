@php
    $veiculoAtual = $veiculo ?? null;
@endphp

<div class="grid gap-6 lg:grid-cols-2">
    <label class="space-y-2">
        <span class="text-sm font-semibold text-slate-200">Modelo</span>
        <x-text-input type="text" name="modelo" value="{{ old('modelo', $veiculoAtual->modelo ?? '') }}" placeholder="Ex.: Corolla Altis" />
        @error('modelo') <p class="text-sm text-rose-300">{{ $message }}</p> @enderror
    </label>

    <label class="space-y-2">
        <span class="text-sm font-semibold text-slate-200">Marca</span>
        <x-text-input type="text" name="marca" value="{{ old('marca', $veiculoAtual->marca ?? '') }}" placeholder="Ex.: Toyota" />
        @error('marca') <p class="text-sm text-rose-300">{{ $message }}</p> @enderror
    </label>

    <label class="space-y-2">
        <span class="text-sm font-semibold text-slate-200">Ano</span>
        <x-text-input type="number" name="ano" value="{{ old('ano', $veiculoAtual->ano ?? '') }}" min="1900" max="{{ date('Y') }}" placeholder="2024" />
        @error('ano') <p class="text-sm text-rose-300">{{ $message }}</p> @enderror
    </label>

    <label class="space-y-2">
        <span class="text-sm font-semibold text-slate-200">Placa</span>
        <x-text-input type="text" name="placa" value="{{ old('placa', $veiculoAtual->placa ?? '') }}" placeholder="ABC-1D23" />
        @error('placa') <p class="text-sm text-rose-300">{{ $message }}</p> @enderror
    </label>

    <label class="space-y-2">
        <span class="text-sm font-semibold text-slate-200">Status</span>
        <x-select-input name="status">
            @foreach ($statusOptions as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $veiculoAtual->status ?? 'disponivel') === $value)>{{ $label }}</option>
            @endforeach
        </x-select-input>
        @error('status') <p class="text-sm text-rose-300">{{ $message }}</p> @enderror
    </label>

    <label class="space-y-2 lg:col-span-2">
        <span class="text-sm font-semibold text-slate-200">Imagem do veículo</span>
        <x-file-input name="imagem" accept="image/*" />
        @if (! empty($veiculoAtual?->imagem_url))
            <p class="text-sm text-slate-400">Imagem atual carregada. Se enviar outra, ela substitui a anterior.</p>
        @endif
        @error('imagem') <p class="text-sm text-rose-300">{{ $message }}</p> @enderror
    </label>
</div>
