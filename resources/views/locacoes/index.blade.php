<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.35em] text-amber-200/70">Cadastro</p>
                <h2 class="mt-2 text-3xl font-black text-white">Locações</h2>
            </div>
            @can('gerenciar locacoes')
                <a href="{{ route('locacoes.create') }}" class="rounded-full bg-amber-400 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-amber-300">Nova locação</a>
            @endcan
        </div>
    </x-slot>

    <div class="rounded-[2rem] border border-white/10 bg-slate-950/55 p-6 shadow-2xl shadow-black/20">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/10">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-[0.3em] text-slate-400">
                        <th class="px-4 py-3">Cliente</th>
                        <th class="px-4 py-3">Veículo</th>
                        <th class="px-4 py-3">Retirada</th>
                        <th class="px-4 py-3">Devolução</th>
                        <th class="px-4 py-3">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse ($locacoes as $locacao)
                        <tr>
                            <td class="px-4 py-4">
                                <a href="{{ route('locacoes.show', $locacao) }}" class="font-bold text-white hover:text-amber-200">{{ $locacao->cliente }}</a>
                            </td>
                            <td class="px-4 py-4 text-slate-200">{{ $locacao->veiculo?->modelo ?? 'Veículo removido' }}</td>
                            <td class="px-4 py-4 text-slate-200">{{ $locacao->data_retirada->format('d/m/Y') }}</td>
                            <td class="px-4 py-4 text-slate-200">{{ $locacao->data_devolucao->format('d/m/Y') }}</td>
                            <td class="px-4 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('locacoes.show', $locacao) }}" class="rounded-full border border-white/10 px-3 py-2 text-xs font-semibold text-slate-200 hover:bg-white/10">Ver</a>
                                    @can('gerenciar locacoes')
                                        <a href="{{ route('locacoes.edit', $locacao) }}" class="rounded-full border border-amber-400/30 px-3 py-2 text-xs font-semibold text-amber-200 hover:bg-amber-400/10">Editar</a>
                                        <form method="POST" action="{{ route('locacoes.destroy', $locacao) }}" onsubmit="return confirm('Remover esta locação?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-full border border-rose-400/30 px-3 py-2 text-xs font-semibold text-rose-200 hover:bg-rose-400/10">Excluir</button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-slate-400">Nenhuma locação cadastrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $locacoes->links() }}
        </div>
    </div>
</x-app-layout>
