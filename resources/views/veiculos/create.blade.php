<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.35em] text-amber-200/70">Cadastro</p>
            <h2 class="mt-2 text-3xl font-black text-white">Novo veículo</h2>
        </div>
    </x-slot>

    <div class="rounded-[2rem] border border-white/10 bg-slate-950/55 p-6 shadow-2xl shadow-black/20">
        <form method="POST" action="{{ route('veiculos.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @include('veiculos._form', ['veiculo' => null])

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('veiculos.index') }}" class="rounded-full border border-white/10 px-5 py-3 text-sm font-semibold text-slate-200 hover:bg-white/10">Cancelar</a>
                <button type="submit" class="rounded-full bg-amber-400 px-5 py-3 text-sm font-semibold text-slate-950 hover:bg-amber-300">Salvar veículo</button>
            </div>
        </form>
    </div>
</x-app-layout>
