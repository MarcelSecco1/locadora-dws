@props(['disabled' => false])

<input
    type="file"
    @disabled($disabled)
    {{ $attributes->merge(['class' => 'block w-full rounded-2xl border border-dashed border-white/15 bg-white/5 px-4 py-3 text-sm text-slate-200 shadow-sm shadow-black/10 outline-none transition file:mr-4 file:rounded-full file:border-0 file:bg-amber-400 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-slate-950 hover:file:bg-amber-300 focus:border-amber-400 focus:ring-4 focus:ring-amber-400/15 disabled:cursor-not-allowed disabled:opacity-60']) }}
>
