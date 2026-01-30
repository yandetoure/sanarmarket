@extends('layouts.app')

@section('title', 'Toutes les boutiques - Sanar Market')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Toutes les boutiques</h1>
        <p class="text-muted-foreground">
            {{ $boutiques->total() }} boutique{{ $boutiques->total() > 1 ? 's' : '' }} 
            disponible{{ $boutiques->total() > 1 ? 's' : '' }}
        </p>
    </div>

    @if($boutiques->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($boutiques as $boutique)
                <a href="{{ route('boutiques.public.show', $boutique) }}" class="bg-white rounded-3xl overflow-hidden shadow-[0_20px_60px_-40px_rgba(15,23,42,0.55)] hover:shadow-[0_30px_80px_-45px_rgba(14,116,144,0.45)] transition-all hover:-translate-y-1 border border-slate-200 block">
                    <div class="aspect-video relative overflow-hidden bg-slate-100">
                        @if($boutique->cover_image)
                            <img src="{{ asset('storage/' . $boutique->cover_image) }}" 
                                 alt="{{ $boutique->name }}"
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-primary/10 to-primary/5">
                                <i data-lucide="store" class="w-16 h-16 text-primary/40"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <h3 class="font-semibold text-xl text-slate-900 line-clamp-1">{{ $boutique->name }}</h3>
                        </div>
                        
                        @if($boutique->description)
                        <p class="text-muted-foreground line-clamp-2 mb-4">
                            {{ $boutique->description }}
                        </p>
                        @endif
                        
                        <div class="flex items-center gap-4 text-muted-foreground mb-4">
                            @if($boutique->address)
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                                <span class="text-sm">{{ $boutique->address }}</span>
                            </div>
                            @endif
                            @if($boutique->articles_count > 0)
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="package" class="w-4 h-4"></i>
                                <span class="text-sm">{{ $boutique->articles_count }} article{{ $boutique->articles_count > 1 ? 's' : '' }}</span>
                            </div>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-slate-200">
                            <span class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">
                                Boutique
                            </span>
                            <span class="text-primary hover:text-primary/80 text-sm font-semibold flex items-center gap-1">
                                Voir la boutique
                                <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $boutiques->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i data-lucide="store" class="w-16 h-16 text-muted-foreground mx-auto mb-4"></i>
            <p class="text-muted-foreground text-lg">Aucune boutique disponible</p>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection

