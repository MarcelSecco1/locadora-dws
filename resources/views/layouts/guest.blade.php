<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Locadora Prime') }}</title>
        <meta name="theme-color" content="#0f172a">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-100">
        <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(245,158,11,0.18),_transparent_35%),linear-gradient(180deg,_#08111f_0%,_#0f172a_46%,_#111827_100%)]">
            <div class="mx-auto flex min-h-screen w-full max-w-7xl flex-col justify-center px-4 py-10 sm:px-6 lg:px-8">
                <div class="mb-8 flex items-center gap-3">
                    <a href="/" class="flex items-center gap-3 text-2xl font-black tracking-tight text-white">
                        <span class="grid h-11 w-11 place-items-center rounded-2xl bg-amber-400 text-slate-950 shadow-lg shadow-amber-400/30">LP</span>
                        <span>Locadora Prime</span>
                    </a>
                </div>

                <div class="grid gap-8 lg:grid-cols-[1.1fr_minmax(0,420px)] lg:items-center">
                    <div class="space-y-6">
                        <span class="inline-flex rounded-full border border-amber-400/30 bg-amber-400/10 px-4 py-2 text-sm font-semibold text-amber-200">CRUD completo com autenticação Breeze</span>
                        <div class="space-y-4">
                            <h1 class="max-w-2xl text-4xl font-black tracking-tight text-white sm:text-5xl">Controle veículos, locações e imagens em uma interface limpa e responsiva.</h1>
                            <p class="max-w-xl text-base leading-7 text-slate-300">A base foi desenhada para o tema da locadora com MySQL, upload de imagens, menu próprio e escrita protegida por login.</p>
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-white/10 bg-slate-950/60 p-2 shadow-2xl shadow-black/30 backdrop-blur">
                        <div class="rounded-[1.5rem] border border-white/10 bg-slate-900/80 p-6">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
