<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.35em] text-amber-200/70">Cadastro</p>
                <h2 class="mt-2 text-3xl font-black text-white">Veículos</h2>
            </div>
            @can('gerenciar veiculos')
                <a href="{{ route('veiculos.create') }}" class="rounded-full bg-amber-400 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-amber-300">Novo veículo</a>
            @endcan
        </div>
    </x-slot>

    <div class="rounded-[2rem] border border-white/10 bg-slate-950/55 p-6 shadow-2xl shadow-black/20">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/10">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-[0.3em] text-slate-400">
                        <th class="px-4 py-3">Veículo</th>
                        <th class="px-4 py-3">Ano</th>
                        <th class="px-4 py-3">Placa</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse ($veiculos as $veiculo)
                        <tr class="align-top">
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="h-16 w-16 overflow-hidden rounded-2xl bg-slate-800">
                                        @if ($veiculo->imagem_url)
                                            <img src="{{ $veiculo->imagem_url }}" alt="{{ $veiculo->modelo }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="grid h-full w-full place-items-center bg-gradient-to-br from-amber-400 to-orange-500 text-[10px] font-black text-slate-950">SEM FOTO</div>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('veiculos.show', $veiculo) }}" class="font-bold text-white hover:text-amber-200">{{ $veiculo->modelo }}</a>
                                        <div class="text-sm text-slate-300">{{ $veiculo->marca }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-slate-200">{{ $veiculo->ano }}</td>
                            <td class="px-4 py-4 text-slate-200">{{ $veiculo->placa }}</td>
                            <td class="px-4 py-4">
                                <x-veiculo-status :veiculo="$veiculo" />
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('veiculos.show', $veiculo) }}" class="rounded-full border border-white/10 px-3 py-2 text-xs font-semibold text-slate-200 hover:bg-white/10">Ver</a>
                                    @can('gerenciar veiculos')
                                        <a href="{{ route('veiculos.edit', $veiculo) }}" class="rounded-full border border-amber-400/30 px-3 py-2 text-xs font-semibold text-amber-200 hover:bg-amber-400/10">Editar</a>
                                        <form method="POST" action="{{ route('veiculos.destroy', $veiculo) }}" onsubmit="return confirm('Remover este veículo?');">
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
                            <td colspan="5" class="px-4 py-10 text-center text-slate-400">Nenhum veículo cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $veiculos->links() }}
        </div>
    </div>
</x-app-layout>
