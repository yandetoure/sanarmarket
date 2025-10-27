@extends('layouts.app')

@section('title', 'Sanar Market - Le marketplace des étudiants africains')

@section('content')
<!-- Hero Section -->
<section class="relative h-[500px] overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1638636214032-581196ffd400?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHx1bml2ZXJzaXR5JTIwc3R1ZGVudHMlMjBjYW1wdXN8ZW58MXx8fHwxNzYxMTQ1MzAxfDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral" 
             alt="Hero background" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/50"></div>
    </div>
    
    <div class="relative container mx-auto px-4 h-full flex flex-col justify-center items-start">
        <div class="max-w-2xl">
            <h2 class="text-white mb-4 text-4xl font-semibold">
                Le marketplace des étudiants africains
            </h2>
            <p class="text-white/90 mb-8 text-lg">
                Achetez et vendez tout ce dont vous avez besoin pour vos études : livres, fournitures, 
                savons, vêtements et plus encore. Par des étudiants africains, pour des étudiants africains.
            </p>
            
            <form method="GET" action="{{ route('home') }}" class="flex gap-2 bg-white p-2 rounded-lg shadow-lg max-w-xl">
                <input type="text" 
                       name="search" 
                       placeholder="Rechercher une annonce..." 
                       value="{{ request('search') }}"
                       class="flex-1 border-0 focus:ring-0 px-3 py-2 text-gray-900 placeholder-gray-500">
                <button type="submit" class="bg-primary text-primary-foreground px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-2">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    Rechercher
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Publicités Hero -->
@php
    use App\Models\Advertisement;
    
    $heroAds = Advertisement::where('is_active', true)
        ->where('type', 'banner')
        ->where('position', 'hero')
        ->where(function($query) {
            $query->whereNull('start_date')
                  ->orWhere('start_date', '<=', now());
        })
        ->where(function($query) {
            $query->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
        })
        ->get();
@endphp

@if($heroAds->count() > 0)
    <div class="container mx-auto px-4 py-8">
        @foreach($heroAds as $ad)
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl shadow-lg overflow-hidden mb-6">
                <div class="p-8">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold mb-2">{{ $ad->title }}</h2>
                            <p class="text-blue-100 mb-4">{{ $ad->content }}</p>
                            @if($ad->link)
                                <a href="{{ $ad->link }}" target="_blank" class="inline-block bg-white text-blue-600 px-6 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors">
                                    Découvrir
                                </a>
                            @endif
                        </div>
                        @if($ad->image)
                            <div class="ml-8">
                                <img src="{{ Storage::url($ad->image) }}" alt="{{ $ad->title }}" class="w-32 h-32 object-cover rounded-lg">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<!-- Category Filter -->
<div class="border-b bg-white">
    <div class="container mx-auto px-4 py-4">
        <div class="flex gap-2 overflow-x-auto">
            <a href="{{ route('home') }}" 
               class="px-4 py-2 rounded-lg border border-border hover:bg-muted transition-colors flex items-center gap-2 whitespace-nowrap {{ !request('category') || request('category') === 'all' ? 'bg-primary text-primary-foreground border-primary' : 'bg-white' }}">
                <i data-lucide="more-horizontal" class="w-4 h-4"></i>
                Toutes
            </a>
            @foreach($categories as $category)
                <a href="{{ route('home', ['category' => $category->slug]) }}" 
                   class="px-4 py-2 rounded-lg border border-border hover:bg-muted transition-colors flex items-center gap-2 whitespace-nowrap {{ request('category') === $category->slug ? 'bg-primary text-primary-foreground border-primary' : 'bg-white' }}">
                    <i data-lucide="{{ $category->icon }}" class="w-4 h-4"></i>
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold mb-2">
            @if(request('category') && request('category') !== 'all')
                Annonces - {{ $categories->where('slug', request('category'))->first()->name ?? 'Catégorie' }}
            @else
                Toutes les annonces
            @endif
        </h2>
        <p class="text-muted-foreground">
            {{ $announcements->count() }} annonce{{ $announcements->count() > 1 ? 's' : '' }} 
            disponible{{ $announcements->count() > 1 ? 's' : '' }}
        </p>
    </div>

    @if($announcements->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($announcements as $announcement)
                <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow cursor-pointer border border-border">
                    <div class="aspect-video relative overflow-hidden">
                        <img src="{{ $announcement->image_url }}" 
                             alt="{{ $announcement->title }}"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        @if($announcement->featured)
                            <div class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded text-sm font-medium">
                                En vedette
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-4">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <h3 class="font-medium text-lg line-clamp-1">{{ $announcement->title }}</h3>
                            <p class="text-primary font-semibold whitespace-nowrap">{{ $announcement->price }}</p>
                        </div>
                        
                        <p class="text-muted-foreground line-clamp-2 mb-3">
                            {{ $announcement->description }}
                        </p>
                        
                        <div class="flex items-center gap-4 text-muted-foreground mb-3">
                            <div class="flex items-center gap-1">
                                <i data-lucide="map-pin" class="w-3 h-3"></i>
                                <span class="text-sm">{{ $announcement->location }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <i data-lucide="clock" class="w-3 h-3"></i>
                                <span class="text-sm">{{ $announcement->formatted_date }}</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="bg-secondary text-secondary-foreground px-2 py-1 rounded text-sm">
                                {{ $announcement->category->name }}
                            </span>
                            <a href="{{ route('announcements.show', $announcement) }}" 
                               class="text-primary hover:text-primary/80 text-sm font-medium">
                                Voir plus →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <i data-lucide="search" class="w-16 h-16 text-muted-foreground mx-auto mb-4"></i>
            <p class="text-muted-foreground text-lg">Aucune annonce trouvée</p>
            <p class="text-muted-foreground">Essayez de modifier vos critères de recherche</p>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection
