<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Locadora Prime') }}</title>
    <meta name="theme-color" content="#0f172a">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-100">
    <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(245,158,11,0.18),_transparent_35%),linear-gradient(180deg,_#08111f_0%,_#0f172a_46%,_#111827_100%)]">
        <header class="mx-auto flex max-w-7xl items-center justify-between px-4 py-6 sm:px-6 lg:px-8">
            <a href="/" class="flex items-center gap-3">
                <span class="grid h-11 w-11 place-items-center rounded-2xl bg-amber-400 text-slate-950 shadow-lg shadow-amber-400/30">LP</span>
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.35em] text-amber-200/70">Locadora</div>
                    <div class="text-lg font-black text-white">Prime</div>
                </div>
            </a>
            <div class="flex items-center gap-3 text-sm font-semibold">
                <a href="{{ route('veiculos.index') }}" class="rounded-full border border-white/10 px-4 py-2 text-slate-200 hover:bg-white/10">Catálogo</a>
                @auth
                    @can('acessar dashboard')
                        <a href="{{ route('dashboard') }}" class="rounded-full bg-white px-4 py-2 text-slate-950 hover:bg-amber-300">Dashboard</a>
                    @else
                        <a href="{{ route('profile.edit') }}" class="rounded-full bg-white px-4 py-2 text-slate-950 hover:bg-amber-300">Minha conta</a>
                    @endcan
                @else
                    <a href="{{ route('login') }}" class="rounded-full bg-white px-4 py-2 text-slate-950 hover:bg-amber-300">Entrar</a>
                @endauth
            </div>
        </header>

        <main class="mx-auto grid max-w-7xl gap-8 px-4 pb-16 pt-8 sm:px-6 lg:grid-cols-[1.05fr_0.95fr] lg:px-8 lg:pb-24 lg:pt-12">
            <section class="space-y-8">
                <div class="inline-flex rounded-full border border-amber-400/30 bg-amber-400/10 px-4 py-2 text-sm font-semibold text-amber-200">
                    CRUD Laravel + Breeze + MySQL + Docker
                </div>

                <div class="space-y-5">
                    <h1 class="max-w-3xl text-5xl font-black tracking-tight text-white sm:text-6xl">Controle a frota e as locações em uma interface elegante, rápida e pronta para apresentar.</h1>
                    <p class="max-w-2xl text-lg leading-8 text-slate-300">A aplicação foi montada com autenticação Breeze, upload de imagem para veículos, relacionamento obrigatório entre as tabelas e regras de acesso que deixam a listagem pública e protegem escrita atrás do login.</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                        <div class="text-3xl font-black text-white">{{ $veiculosCount }}</div>
                        <div class="mt-1 text-sm text-slate-300">Veículos cadastrados</div>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                        <div class="text-3xl font-black text-white">{{ $locacoesCount }}</div>
                        <div class="mt-1 text-sm text-slate-300">Locações registradas</div>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                        <div class="text-3xl font-black text-white">{{ $disponiveisCount }}</div>
                        <div class="mt-1 text-sm text-slate-300">Veículos disponíveis</div>
                    </div>
                </div>
            </section>

            <section class="grid gap-4">
                <div class="rounded-[2rem] border border-white/10 bg-slate-950/55 p-6 shadow-2xl shadow-black/30 backdrop-blur">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-black text-white">Veículos em destaque</h2>
                        <a href="{{ route('veiculos.index') }}" class="text-sm font-semibold text-amber-200 hover:text-amber-100">Ver todos</a>
                    </div>
                    <div class="mt-5 space-y-4">
                        @forelse ($veiculos as $veiculo)
                            <a href="{{ route('veiculos.show', $veiculo) }}" class="flex items-center gap-4 rounded-2xl border border-white/10 bg-white/5 p-4 transition hover:-translate-y-0.5 hover:border-amber-400/30 hover:bg-white/10">
                                <div class="h-16 w-16 overflow-hidden rounded-2xl bg-slate-800">
                                    @if ($veiculo->imagem_url)
                                        <img src="{{ $veiculo->imagem_url }}" alt="{{ $veiculo->modelo }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="grid h-full w-full place-items-center bg-gradient-to-br from-amber-400 to-orange-500 text-xs font-black text-slate-950">SEM FOTO</div>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="truncate text-base font-bold text-white">{{ $veiculo->modelo }}</div>
                                    <div class="text-sm text-slate-300">{{ $veiculo->marca }} • {{ $veiculo->ano }} • {{ $veiculo->placa }}</div>
                                </div>
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $veiculo->status === 'disponivel' ? 'bg-emerald-400/15 text-emerald-200' : ($veiculo->status === 'alugado' ? 'bg-sky-400/15 text-sky-200' : 'bg-amber-400/15 text-amber-200') }}">
                                    {{ ucfirst($veiculo->status) }}
                                </span>
                            </a>
                        @empty
                            <p class="text-sm text-slate-400">Nenhum veículo cadastrado ainda.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-[2rem] border border-white/10 bg-slate-950/55 p-6 shadow-2xl shadow-black/30 backdrop-blur">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-black text-white">Locações recentes</h2>
                        <a href="{{ route('locacoes.index') }}" class="text-sm font-semibold text-amber-200 hover:text-amber-100">Ver todas</a>
                    </div>
                    <div class="mt-5 space-y-4">
                        @forelse ($locacoes as $locacao)
                            <div class="rounded-2xl border border-white/10 border-l-4 border-l-amber-400/80 bg-white/5 p-4">
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                    <div class="min-w-0">
                                        <div class="truncate text-base font-bold text-white">{{ $locacao->cliente }}</div>
                                        <div class="mt-1 text-sm text-slate-300">{{ $locacao->veiculo?->modelo ?? 'Veículo indisponível' }}</div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
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
                            </div>
                        @empty
                            <p class="text-sm text-slate-400">Nenhuma locação cadastrada ainda.</p>
                        @endforelse
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
