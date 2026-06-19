@props(['disabled' => false])

<input
    type="checkbox"
    @disabled($disabled)
    {{ $attributes->merge(['class' => 'h-5 w-5 rounded border-white/20 bg-white/5 text-amber-400 shadow-sm shadow-black/10 outline-none transition focus:ring-4 focus:ring-amber-400/15']) }}
>
