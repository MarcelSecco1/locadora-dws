<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.35em] text-amber-200/70">Administração</p>
                <h2 class="mt-2 text-3xl font-black text-white">Usuários e permissões</h2>
            </div>
            <a href="{{ route('usuarios.create') }}" class="rounded-full bg-amber-400 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-amber-300">Novo usuário</a>
        </div>
    </x-slot>

    <div class="rounded-[2rem] border border-white/10 bg-slate-950/55 p-6 shadow-2xl shadow-black/20">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/10">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-[0.3em] text-slate-400">
                        <th class="px-4 py-3">Usuário</th>
                        <th class="px-4 py-3">Papel</th>
                        <th class="px-4 py-3">Permissões</th>
                        <th class="px-4 py-3">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse ($users as $user)
                        <tr class="align-top">
                            <td class="px-4 py-4">
                                <div class="font-bold text-white">{{ $user->name }}</div>
                                <div class="text-sm text-slate-300">{{ $user->email }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-slate-100">
                                    {{ $user->roles->pluck('name')->join(', ') ?: 'Sem papel' }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex flex-wrap gap-2">
                                    @forelse ($user->permissions as $permission)
                                        <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-semibold text-slate-200">
                                            {{ $permission->name }}
                                        </span>
                                    @empty
                                        <span class="text-sm text-slate-400">Sem permissões diretas</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <a href="{{ route('usuarios.edit', $user) }}" class="rounded-full border border-amber-400/30 px-3 py-2 text-xs font-semibold text-amber-200 hover:bg-amber-400/10">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center text-slate-400">Nenhum usuário cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
