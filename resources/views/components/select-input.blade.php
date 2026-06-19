@props(['disabled' => false])

@once
    <style>
        select[data-dark-select],
        select[data-dark-select] option,
        select[data-dark-select] optgroup {
            background-color: #020617 !important;
            color: #f1f5f9 !important;
            color-scheme: dark;
        }

        select[data-dark-select] option:checked {
            background-color: #334155 !important;
            color: #ffffff !important;
        }
    </style>
@endonce

<select data-dark-select @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-sm text-slate-100 shadow-sm shadow-black/10 outline-none transition [color-scheme:dark] focus:border-amber-400 focus:ring-4 focus:ring-amber-400/15 disabled:cursor-not-allowed disabled:opacity-60 [&>option]:bg-slate-950 [&>option]:text-slate-100']) }}>
    {{ $slot }}
</select>
