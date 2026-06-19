<nav class="border-b border-white/10 bg-slate-950/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
        <a href="{{ auth()->user()?->can('acessar dashboard') ? route('dashboard') : route('veiculos.index') }}" class="flex items-center gap-3">
            <span class="grid h-11 w-11 place-items-center rounded-2xl bg-amber-400 text-sm font-black tracking-[0.2em] text-slate-950 shadow-lg shadow-amber-400/30">LP</span>
            <span>
                <span class="block text-xs font-semibold uppercase tracking-[0.35em] text-amber-200/70">Sistema</span>
                <span class="block text-lg font-black text-white">Locadora Prime</span>
            </span>
        </a>

        <div class="flex flex-wrap items-center gap-2 text-sm font-semibold">
            @can('acessar dashboard')
                <a href="{{ route('dashboard') }}" class="rounded-full px-4 py-2 {{ request()->routeIs('dashboard') ? 'bg-amber-400 text-slate-950' : 'text-slate-200 hover:bg-white/10' }}">Dashboard</a>
            @endcan
            @can('gerenciar usuarios')
                <a href="{{ route('usuarios.index') }}" class="rounded-full px-4 py-2 {{ request()->routeIs('usuarios.*') ? 'bg-amber-400 text-slate-950' : 'text-slate-200 hover:bg-white/10' }}">Usuários</a>
            @endcan
            <a href="{{ route('veiculos.index') }}" class="rounded-full px-4 py-2 {{ request()->routeIs('veiculos.*') ? 'bg-amber-400 text-slate-950' : 'text-slate-200 hover:bg-white/10' }}">Veículos</a>
            <a href="{{ route('locacoes.index') }}" class="rounded-full px-4 py-2 {{ request()->routeIs('locacoes.*') ? 'bg-amber-400 text-slate-950' : 'text-slate-200 hover:bg-white/10' }}">Locações</a>
        </div>

        <div class="flex flex-wrap items-center gap-3 text-sm">
            @auth
                <a href="{{ route('profile.edit') }}" class="rounded-full border border-white/10 px-4 py-2 text-slate-200 transition hover:border-amber-400/50 hover:bg-amber-400/10 hover:text-amber-100">
                    {{ auth()->user()->name }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-full bg-white px-4 py-2 font-semibold text-slate-950 transition hover:bg-amber-300">
                        Sair
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="rounded-full border border-white/10 px-4 py-2 text-slate-200 transition hover:border-amber-400/50 hover:bg-amber-400/10 hover:text-amber-100">Entrar</a>
                <a href="{{ route('register') }}" class="rounded-full bg-white px-4 py-2 font-semibold text-slate-950 transition hover:bg-amber-300">Criar conta</a>
            @endauth
        </div>
    </div>
</nav>
