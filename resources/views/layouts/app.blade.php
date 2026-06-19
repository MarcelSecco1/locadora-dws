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
            @include('layouts.navigation')

            @isset($header)
                <header class="border-b border-white/10 bg-white/5 backdrop-blur">
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-400/30 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('status'))
                    <div class="mb-6 rounded-2xl border border-sky-400/30 bg-sky-400/10 px-4 py-3 text-sm text-sky-200">
                        {{ session('status') }}
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </body>
</html>
