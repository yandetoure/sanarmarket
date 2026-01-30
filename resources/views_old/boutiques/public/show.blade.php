@extends('layouts.app')

@section('title', $boutique->name . ' - Sanar Market')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('boutiques.index') }}" class="inline-flex items-center gap-2 text-primary hover:text-primary/80 mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Retour aux boutiques
        </a>
    </div>

    <div class="bg-white rounded-3xl overflow-hidden shadow-lg border border-slate-200 mb-8">
        @if($boutique->cover_image)
        <div class="aspect-video relative overflow-hidden bg-slate-100">
            <img src="{{ asset('storage/' . $boutique->cover_image) }}" 
                 alt="{{ $boutique->name }}"
                 class="w-full h-full object-cover">
        </div>
        @endif
        
        <div class="p-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $boutique->name }}</h1>
            
            @if($boutique->description)
            <p class="text-lg text-muted-foreground mb-6">{{ $boutique->description }}</p>
            @endif
            
            <div class="flex flex-wrap gap-4 mb-6">
                @if($boutique->address)
                <div class="flex items-center gap-2 text-muted-foreground">
                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                    <span>{{ $boutique->address }}</span>
                </div>
                @endif
                @if($boutique->phone)
                <div class="flex items-center gap-2 text-muted-foreground">
                    <i data-lucide="phone" class="w-5 h-5"></i>
                    <span>{{ $boutique->phone }}</span>
                </div>
                @endif
                <div class="flex items-center gap-2 text-muted-foreground">
                    <i data-lucide="user" class="w-5 h-5"></i>
                    <span>{{ $boutique->user->name }}</span>
                </div>
            </div>

            @if($boutique->social_links && count($boutique->social_links) > 0)
            <div class="flex gap-3 mb-6">
                @if(isset($boutique->social_links['facebook']))
                <a href="{{ $boutique->social_links['facebook'] }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-700">
                    <i data-lucide="facebook" class="w-5 h-5"></i>
                </a>
                @endif
                @if(isset($boutique->social_links['instagram']))
                <a href="{{ $boutique->social_links['instagram'] }}" target="_blank" rel="noopener noreferrer" class="text-pink-600 hover:text-pink-700">
                    <i data-lucide="instagram" class="w-5 h-5"></i>
                </a>
                @endif
                @if(isset($boutique->social_links['twitter']))
                <a href="{{ $boutique->social_links['twitter'] }}" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-500">
                    <i data-lucide="twitter" class="w-5 h-5"></i>
                </a>
                @endif
                @if(isset($boutique->social_links['website']))
                <a href="{{ $boutique->social_links['website'] }}" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-gray-700">
                    <i data-lucide="globe" class="w-5 h-5"></i>
                </a>
                @endif
            </div>
            @endif
        </div>
    </div>

    @if($boutique->articles->count() > 0)
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Articles disponibles</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($boutique->articles as $article)
                <div class="bg-white rounded-3xl overflow-hidden shadow-[0_20px_60px_-40px_rgba(15,23,42,0.55)] hover:shadow-[0_30px_80px_-45px_rgba(14,116,144,0.45)] transition-all hover:-translate-y-1 border border-slate-200">
                    <div class="aspect-video relative overflow-hidden bg-slate-100">
                        @if($article->image)
                            <img src="{{ asset('storage/' . $article->image) }}" 
                                 alt="{{ $article->name }}"
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-primary/10 to-primary/5">
                                <i data-lucide="package" class="w-16 h-16 text-primary/40"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <div>
                                <h3 class="font-semibold text-xl text-slate-900 line-clamp-1">{{ $article->name }}</h3>
                                @if($article->category)
                                <p class="text-sm text-primary/80 mt-1">{{ $article->category->name }}</p>
                                @endif
                            </div>
                            <p class="rounded-full bg-primary/10 px-3 py-1 text-base font-semibold text-primary whitespace-nowrap">
                                {{ number_format($article->price, 0, ',', ' ') }} FCFA
                            </p>
                        </div>
                        
                        @if($article->description)
                        <p class="text-muted-foreground line-clamp-2 mb-4">
                            {{ $article->description }}
                        </p>
                        @endif
                        
                        <div class="flex items-center gap-4 text-muted-foreground mb-4">
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="package" class="w-4 h-4"></i>
                                <span class="text-sm">Stock: {{ $article->stock }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="text-center py-12 bg-white rounded-3xl border border-slate-200">
        <i data-lucide="package" class="w-16 h-16 text-muted-foreground mx-auto mb-4"></i>
        <p class="text-muted-foreground text-lg">Aucun article disponible pour le moment</p>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection

