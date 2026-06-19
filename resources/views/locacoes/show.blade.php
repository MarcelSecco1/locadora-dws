<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.35em] text-amber-200/70">Detalhe</p>
                <h2 class="mt-2 text-3xl font-black text-white">{{ $locacao->cliente }}</h2>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('locacoes.index') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold text-slate-100 hover:bg-white/10">Voltar</a>
                @can('gerenciar locacoes')
                    <a href="{{ route('locacoes.edit', $locacao) }}" class="rounded-full bg-amber-400 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-amber-300">Editar</a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="grid gap-6 xl:grid-cols-[1fr_380px]">
        <section class="rounded-[2rem] border border-white/10 bg-slate-950/55 p-6 shadow-2xl shadow-black/20">
            <h3 class="text-lg font-black text-white">Dados da locação</h3>
            <dl class="mt-5 grid gap-4 sm:grid-cols-2">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <dt class="text-sm text-slate-400">Cliente</dt>
                    <dd class="mt-1 font-semibold text-white">{{ $locacao->cliente }}</dd>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <dt class="text-sm text-slate-400">Veículo</dt>
                    <dd class="mt-1 font-semibold text-white">{{ $locacao->veiculo?->modelo ?? 'Veículo removido' }}</dd>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <dt class="text-sm text-slate-400">Retirada</dt>
                    <dd class="mt-1 font-semibold text-white">{{ $locacao->data_retirada->format('d/m/Y') }}</dd>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <dt class="text-sm text-slate-400">Devolução</dt>
                    <dd class="mt-1 font-semibold text-white">{{ $locacao->data_devolucao->format('d/m/Y') }}</dd>
                </div>
            </dl>
        </section>

        <section class="rounded-[2rem] border border-white/10 bg-slate-950/55 p-6 shadow-2xl shadow-black/20">
            <h3 class="text-lg font-black text-white">Veículo relacionado</h3>
            @if ($locacao->veiculo)
                <a href="{{ route('veiculos.show', $locacao->veiculo) }}" class="mt-5 block overflow-hidden rounded-3xl border border-white/10 bg-white/5 hover:bg-white/10">
                    <div class="aspect-[4/3] bg-slate-800">
                        @if ($locacao->veiculo->imagem_url)
                            <img src="{{ $locacao->veiculo->imagem_url }}" alt="{{ $locacao->veiculo->modelo }}" class="h-full w-full object-cover">
                        @else
                            <div class="grid h-full w-full place-items-center bg-gradient-to-br from-amber-400 to-orange-500 text-lg font-black text-slate-950">SEM IMAGEM</div>
                        @endif
                    </div>
                    <div class="space-y-2 p-5">
                        <div class="text-xl font-black text-white">{{ $locacao->veiculo->modelo }}</div>
                        <div class="text-sm text-slate-300">{{ $locacao->veiculo->marca }} • {{ $locacao->veiculo->placa }}</div>
                    </div>
                </a>
            @else
                <p class="mt-5 text-sm text-slate-400">O veículo relacionado não está mais disponível no sistema.</p>
            @endif
        </section>
    </div>
</x-app-layout>
