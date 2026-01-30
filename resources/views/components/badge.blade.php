@props(['variant' => 'slate', 'size' => 'md'])

@php
    $baseStyles = "inline-flex items-center font-bold px-2 py-0.5 rounded-lg tracking-wider uppercase";

    $variants = [
        'slate' => 'bg-slate-100 text-slate-600',
        'primary' => 'bg-primary-100 text-primary-600',
        'secondary' => 'bg-secondary-100 text-secondary-600',
        'orange' => 'bg-orange-100 text-orange-600',
        'emerald' => 'bg-emerald-100 text-emerald-600',
        'purple' => 'bg-purple-100 text-purple-600',
        'red' => 'bg-red-100 text-red-600',
    ];

    $sizes = [
        'xs' => 'text-[9px]',
        'sm' => 'text-[10px]',
        'md' => 'text-[11px]',
    ];

    $classes = $baseStyles . ' ' . ($variants[$variant] ?? $variants['slate']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>