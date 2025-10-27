@extends('layouts.app')

@section('title', 'Toutes les annonces - Sanar Market')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            @if(request('category') && request('category') !== 'all')
                Annonces - {{ \App\Models\Category::where('slug', request('category'))->first()->name ?? 'Catégorie' }}
            @else
                Toutes les annonces
            @endif
        </h1>
        <p class="text-muted-foreground">
            {{ $announcements->total() }} annonce{{ $announcements->total() > 1 ? 's' : '' }} 
            disponible{{ $announcements->total() > 1 ? 's' : '' }}
        </p>
    </div>

    <!-- Category Filter -->
    <div class="mb-8">
        <div class="flex gap-2 overflow-x-auto pb-2">
            <a href="{{ route('announcements.index') }}" 
               class="px-4 py-2 rounded-lg border border-border hover:bg-muted transition-colors flex items-center gap-2 whitespace-nowrap {{ !request('category') || request('category') === 'all' ? 'bg-primary text-primary-foreground border-primary' : 'bg-white' }}">
                <i data-lucide="more-horizontal" class="w-4 h-4"></i>
                Toutes
            </a>
            @foreach(\App\Models\Category::all() as $category)
                <a href="{{ route('announcements.index', ['category' => $category->slug]) }}" 
                   class="px-4 py-2 rounded-lg border border-border hover:bg-muted transition-colors flex items-center gap-2 whitespace-nowrap {{ request('category') === $category->slug ? 'bg-primary text-primary-foreground border-primary' : 'bg-white' }}">
                    <i data-lucide="{{ $category->icon }}" class="w-4 h-4"></i>
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
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

        <!-- Pagination -->
        <div class="mt-8">
            {{ $announcements->links() }}
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

