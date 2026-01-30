@props(['variant' => 'primary', 'size' => 'md', 'type' => 'button'])

@php
    $baseStyles = "inline-flex items-center justify-center font-semibold rounded-xl transition-all focus:outline-none focus:ring-2 focus:ring-offset-2";

    $variants = [
        'primary' => 'bg-primary-600 text-white hover:bg-primary-700 shadow-lg shadow-primary-100 hover:shadow-primary-200 focus:ring-primary-500',
        'secondary' => 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 hover:border-slate-300 shadow-sm focus:ring-slate-400',
        'accent' => 'bg-secondary-500 text-white hover:bg-secondary-600 shadow-lg shadow-secondary-100 focus:ring-secondary-400',
        'ghost' => 'bg-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900',
        'danger' => 'bg-red-500 text-white hover:bg-red-600 shadow-lg shadow-red-100 focus:ring-red-400',
    ];

    $sizes = [
        'xs' => 'px-3 py-1.5 text-xs',
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-6 py-2.5 text-base',
        'lg' => 'px-8 py-3.5 text-lg',
    ];

    $classes = $baseStyles . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if($attributes->has('href'))
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif