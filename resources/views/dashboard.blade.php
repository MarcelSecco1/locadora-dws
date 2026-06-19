<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.35em] text-amber-200/70">Painel</p>
                <h2 class="mt-2 text-3xl font-black text-white">Resumo operacional da locadora</h2>
            </div>
            <div class="flex gap-3">
                @can('gerenciar veiculos')
                    <a href="{{ route('veiculos.create') }}" class="rounded-full bg-amber-400 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-amber-300">Novo veículo</a>
                @endcan
                @can('gerenciar locacoes')
                    <a href="{{ route('locacoes.create') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold text-slate-100 hover:bg-white/10">Nova locação</a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-4">
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
            <div class="text-sm text-slate-300">Veículos</div>
            <div class="mt-2 text-4xl font-black text-white">{{ $veiculosCount }}</div>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
            <div class="text-sm text-slate-300">Locações</div>
            <div class="mt-2 text-4xl font-black text-white">{{ $locacoesCount }}</div>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
            <div class="text-sm text-slate-300">Disponíveis</div>
            <div class="mt-2 text-4xl font-black text-emerald-200">{{ $disponiveisCount }}</div>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
            <div class="text-sm text-slate-300">Alugados</div>
            <div class="mt-2 text-4xl font-black text-sky-200">{{ $alugadosCount }}</div>
        </div>
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-2">
        <section class="rounded-[2rem] border border-white/10 bg-slate-950/55 p-6 shadow-2xl shadow-black/20">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-black text-white">Veículos recentes</h3>
                <a href="{{ route('veiculos.index') }}" class="text-sm font-semibold text-amber-200">Abrir lista</a>
            </div>
            <div class="mt-5 space-y-3">
                @forelse ($recentesVeiculos as $veiculo)
                    <a href="{{ route('veiculos.show', $veiculo) }}" class="flex items-center justify-between gap-4 rounded-2xl border border-white/10 bg-white/5 px-4 py-3 hover:bg-white/10">
                        <div>
                            <div class="font-bold text-white">{{ $veiculo->modelo }}</div>
                            <div class="text-sm text-slate-300">{{ $veiculo->marca }} • {{ $veiculo->placa }}</div>
                        </div>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $veiculo->status === 'disponivel' ? 'bg-emerald-400/15 text-emerald-200' : ($veiculo->status === 'alugado' ? 'bg-sky-400/15 text-sky-200' : 'bg-amber-400/15 text-amber-200') }}">
                            {{ ucfirst($veiculo->status) }}
                        </span>
                    </a>
                @empty
                    <p class="text-sm text-slate-400">Sem veículos cadastrados.</p>
                @endforelse
            </div>
        </section>

        <section class="rounded-[2rem] border border-white/10 bg-slate-950/55 p-6 shadow-2xl shadow-black/20">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-black text-white">Locações recentes</h3>
                <a href="{{ route('locacoes.index') }}" class="text-sm font-semibold text-amber-200">Abrir lista</a>
            </div>
            <div class="mt-5 space-y-3">
                @forelse ($recentesLocacoes as $locacao)
                    <a href="{{ route('locacoes.show', $locacao) }}" class="block rounded-2xl border border-white/10 border-l-4 border-l-amber-400/80 bg-white/5 p-4 transition hover:-translate-y-0.5 hover:bg-white/10">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                            <div class="min-w-0">
                                <div class="truncate text-base font-bold text-white">{{ $locacao->cliente }}</div>
                                <div class="mt-1 text-sm text-slate-300">{{ $locacao->veiculo?->modelo ?? 'Veículo removido' }}</div>
                            </div>
                            <div class="grid gap-2 sm:grid-cols-2">
                                <div class="rounded-xl bg-slate-900/80 px-3 py-2">
                                    <div class="text-[10px] font-semibold uppercase tracking-[0.3em] text-slate-400">Retirada</div>
                                    <div class="mt-1 text-sm font-semibold text-slate-100">{{ $locacao->data_retirada->format('d/m/Y') }}</div>
                                </div>
                                <div class="rounded-xl bg-slate-900/80 px-3 py-2">
                                    <div class="text-[10px] font-semibold uppercase tracking-[0.3em] text-slate-400">Devolução</div>
                                    <div class="mt-1 text-sm font-semibold text-slate-100">{{ $locacao->data_devolucao->format('d/m/Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="text-sm text-slate-400">Sem locações cadastradas.</p>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
