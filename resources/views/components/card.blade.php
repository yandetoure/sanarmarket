@props(['title', 'price', 'image', 'category', 'url'])

<div {{ $attributes->merge(['class' => 'group bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-primary-100 transition-all duration-500 overflow-hidden flex flex-col h-full']) }}>
    <a href="{{ $url }}" class="block relative aspect-[4/3] overflow-hidden">
        <img src="{{ $image }}" alt="{{ $title }}"
            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
        <div
            class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
        </div>
        <div class="absolute top-4 left-4">
            <x-badge variant="primary" size="xs" class="glass border-white/20 text-primary-700">
                {{ $category }}
            </x-badge>
        </div>
    </a>

    <div class="p-6 flex flex-col flex-grow">
        <h3
            class="font-display font-bold text-slate-900 text-lg mb-2 group-hover:text-primary-600 transition-colors line-clamp-1">
            {{ $title }}
        </h3>

        <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-50">
            <p class="text-xl font-display font-black text-primary-600">
                {{ number_format((float) $price, 0, ',', ' ') }} <span
                    class="text-xs font-bold uppercase ml-1">FCFA</span>
            </p>
            <x-button :href="$url" variant="ghost" size="xs" class="group/btn">
                Voir
                <svg class="w-4 h-4 ml-1 group-hover/btn:translate-x-1 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </x-button>
        </div>
    </div>
</div>