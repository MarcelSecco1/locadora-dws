<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.35em] text-amber-200/70">Detalhe</p>
                <h2 class="mt-2 text-3xl font-black text-white">{{ $veiculo->modelo }}</h2>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('veiculos.index') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold text-slate-100 hover:bg-white/10">Voltar</a>
                @can('gerenciar veiculos')
                    <a href="{{ route('veiculos.edit', $veiculo) }}" class="rounded-full bg-amber-400 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-amber-300">Editar</a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="grid gap-6 xl:grid-cols-[380px_minmax(0,1fr)]">
        <section class="overflow-hidden rounded-[2rem] border border-white/10 bg-slate-950/55 shadow-2xl shadow-black/20">
            <div class="aspect-[4/3] bg-slate-800">
                @if ($veiculo->imagem_url)
                    <img src="{{ $veiculo->imagem_url }}" alt="{{ $veiculo->modelo }}" class="h-full w-full object-cover">
                @else
                    <div class="grid h-full w-full place-items-center bg-gradient-to-br from-amber-400 to-orange-500 text-lg font-black text-slate-950">SEM IMAGEM</div>
                @endif
            </div>
            <div class="space-y-4 p-6">
                <div class="flex items-center justify-between">
                    <div class="text-sm uppercase tracking-[0.3em] text-slate-400">Status</div>
                    <x-veiculo-status :veiculo="$veiculo" />
                </div>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <dt class="text-slate-400">Marca</dt>
                        <dd class="mt-1 font-semibold text-white">{{ $veiculo->marca }}</dd>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <dt class="text-slate-400">Ano</dt>
                        <dd class="mt-1 font-semibold text-white">{{ $veiculo->ano }}</dd>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <dt class="text-slate-400">Placa</dt>
                        <dd class="mt-1 font-semibold text-white">{{ $veiculo->placa }}</dd>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <dt class="text-slate-400">Locações</dt>
                        <dd class="mt-1 font-semibold text-white">{{ $veiculo->locacoes->count() }}</dd>
                    </div>
                </dl>
            </div>
        </section>

        <section class="rounded-[2rem] border border-white/10 bg-slate-950/55 p-6 shadow-2xl shadow-black/20">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-black text-white">Histórico de locações</h3>
                @can('gerenciar locacoes')
                    <a href="{{ route('locacoes.create') }}" class="text-sm font-semibold text-amber-200">Nova locação</a>
                @endcan
            </div>

            <div class="mt-5 space-y-4">
                @forelse ($veiculo->locacoes as $locacao)
                    <a href="{{ route('locacoes.show', $locacao) }}" class="block rounded-2xl border border-white/10 bg-white/5 p-4 hover:bg-white/10">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div>
                                <div class="font-bold text-white">{{ $locacao->cliente }}</div>
                                <div class="text-sm text-slate-300">{{ $locacao->data_retirada->format('d/m/Y') }} → {{ $locacao->data_devolucao->format('d/m/Y') }}</div>
                            </div>
                            <span class="text-sm text-slate-400">#{{ $locacao->id }}</span>
                        </div>
                    </a>
                @empty
                    <p class="text-sm text-slate-400">Ainda não existem locações para este veículo.</p>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
