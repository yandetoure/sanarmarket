@extends('layouts.app')

@section('title', 'Tous les restaurants - Sanar Market')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Tous les restaurants</h1>
        <p class="text-muted-foreground">
            {{ $restaurants->total() }} restaurant{{ $restaurants->total() > 1 ? 's' : '' }} 
            disponible{{ $restaurants->total() > 1 ? 's' : '' }}
        </p>
    </div>

    @if($restaurants->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($restaurants as $restaurant)
                <a href="{{ route('restaurants.public.show', $restaurant) }}" class="bg-white rounded-3xl overflow-hidden shadow-[0_20px_60px_-40px_rgba(15,23,42,0.55)] hover:shadow-[0_30px_80px_-45px_rgba(14,116,144,0.45)] transition-all hover:-translate-y-1 border border-slate-200 block">
                    <div class="aspect-video relative overflow-hidden bg-slate-100">
                        @if($restaurant->cover_image)
                            <img src="{{ asset('storage/' . $restaurant->cover_image) }}" 
                                 alt="{{ $restaurant->name }}"
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-amber-100 to-orange-50">
                                <i data-lucide="utensils-crossed" class="w-16 h-16 text-amber-400"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <h3 class="font-semibold text-xl text-slate-900 line-clamp-1">{{ $restaurant->name }}</h3>
                        </div>
                        
                        @if($restaurant->description)
                        <p class="text-muted-foreground line-clamp-2 mb-4">
                            {{ $restaurant->description }}
                        </p>
                        @endif
                        
                        <div class="flex items-center gap-4 text-muted-foreground mb-4">
                            @if($restaurant->address)
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                                <span class="text-sm">{{ $restaurant->address }}</span>
                            </div>
                            @endif
                            @if($restaurant->menu_items_count > 0)
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="utensils-crossed" class="w-4 h-4"></i>
                                <span class="text-sm">{{ $restaurant->menu_items_count }} plat{{ $restaurant->menu_items_count > 1 ? 's' : '' }}</span>
                            </div>
                            @endif
                        </div>

                        @if($restaurant->metadata)
                        <div class="flex flex-wrap gap-2 mb-4">
                            @if(isset($restaurant->metadata['cuisine_type']))
                            <span class="bg-amber-100 text-amber-800 px-2 py-1 rounded text-xs font-medium">
                                {{ $restaurant->metadata['cuisine_type'] }}
                            </span>
                            @endif
                            @if(isset($restaurant->metadata['price_range']))
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium">
                                {{ $restaurant->metadata['price_range'] }}
                            </span>
                            @endif
                        </div>
                        @endif
                        
                        <div class="flex items-center justify-between pt-2 border-t border-slate-200">
                            <span class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">
                                Restaurant
                            </span>
                            <span class="text-primary hover:text-primary/80 text-sm font-semibold flex items-center gap-1">
                                Voir le restaurant
                                <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $restaurants->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i data-lucide="utensils-crossed" class="w-16 h-16 text-muted-foreground mx-auto mb-4"></i>
            <p class="text-muted-foreground text-lg">Aucun restaurant disponible</p>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection

