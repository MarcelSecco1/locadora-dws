@props(['veiculo'])

<span {{ $attributes->merge(['class' => 'rounded-full px-3 py-1 text-xs font-semibold '.$veiculo->status_hoje_classes]) }}>
    {{ $veiculo->status_hoje_label }}
</span>
