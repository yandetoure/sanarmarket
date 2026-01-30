@props(['title', 'description' => null, 'linkUrl' => null, 'linkText' => null])

<div {{ $attributes->merge(['class' => 'flex flex-col md:flex-row md:items-end justify-between mb-10']) }}>
    <div>
        <h2 class="text-3xl font-display font-bold text-slate-900 tracking-tight">{{ $title }}</h2>
        @if($description)
            <p class="mt-2 text-slate-500 max-w-2xl">{{ $description }}</p>
        @endif
    </div>

    @if($linkUrl && $linkText)
        <a href="{{ $linkUrl }}"
            class="mt-4 md:mt-0 text-primary-600 font-semibold flex items-center group text-sm transition-all hover:text-primary-700">
            {{ $linkText }}
            <svg class="w-5 h-5 ml-1.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
            </svg>
        </a>
    @endif
</div>