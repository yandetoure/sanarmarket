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

<!-- Category Filter -->
<div class="border-b bg-white">
    <div class="container mx-auto px-4 py-4">
        <div class="flex gap-2 overflow-x-auto" id="category-filter">
            <button data-category="all" 
                    class="px-4 py-2 rounded-lg border border-border hover:bg-muted transition-colors flex items-center gap-2 whitespace-nowrap {{ !request('category') || request('category') === 'all' ? 'bg-primary text-primary-foreground border-primary' : 'bg-white' }}">
                <i data-lucide="more-horizontal" class="w-4 h-4"></i>
                Toutes
            </button>
            @foreach($categories as $category)
                <button data-category="{{ $category->slug }}" 
                        class="px-4 py-2 rounded-lg border border-border hover:bg-muted transition-colors flex items-center gap-2 whitespace-nowrap {{ request('category') === $category->slug ? 'bg-primary text-primary-foreground border-primary' : 'bg-white' }}">
                    <i data-lucide="{{ $category->icon }}" class="w-4 h-4"></i>
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container mx-auto px-4 py-8">
    <div class="mb-6" id="announcements-header">
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

    <div id="announcements-container">
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
</div>
@endsection

@section('scripts')
<script>
    lucide.createIcons();
    
    // Variables globales pour stocker les données
    const categories = @json($categories->keyBy('slug'));
    
    // Fonction pour mettre à jour l'URL sans recharger
    function updateURL(category) {
        const url = new URL(window.location);
        if (category === 'all') {
            url.searchParams.delete('category');
        } else {
            url.searchParams.set('category', category);
        }
        window.history.pushState({ category: category }, '', url);
    }
    
    // Fonction pour charger les annonces via AJAX
    async function loadAnnouncements(category) {
        const url = new URL(window.location.origin + '{{ route("home") }}');
        if (category !== 'all') {
            url.searchParams.set('category', category);
        }
        
        try {
            // Afficher un indicateur de chargement
            const container = document.getElementById('announcements-container');
            container.innerHTML = `
                <div class="text-center py-12">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900"></div>
                    <p class="text-muted-foreground mt-4">Chargement...</p>
                </div>
            `;
            
            // Faire la requête
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            });
            
            const data = await response.json();
            
            // Mettre à jour le header
            const header = document.getElementById('announcements-header');
            header.querySelector('h2').textContent = category === 'all' 
                ? 'Toutes les annonces' 
                : `Annonces - ${categories[category]?.name || 'Catégorie'}`;
            header.querySelector('p').textContent = `${data.count} annonce${data.count > 1 ? 's' : ''} disponible${data.count > 1 ? 's' : ''}`;
            
            // Mettre à jour le contenu
            if (data.count > 0) {
                let html = '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">';
                data.announcements.forEach(announcement => {
                    html += `
                        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow cursor-pointer border border-border">
                            <div class="aspect-video relative overflow-hidden">
                                <img src="${announcement.image_url}" 
                                     alt="${announcement.title}"
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                ${announcement.featured ? '<div class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded text-sm font-medium">En vedette</div>' : ''}
                            </div>
                            
                            <div class="p-4">
                                <div class="flex items-start justify-between gap-2 mb-2">
                                    <h3 class="font-medium text-lg line-clamp-1">${announcement.title}</h3>
                                    <p class="text-primary font-semibold whitespace-nowrap">${announcement.price}</p>
                                </div>
                                
                                <p class="text-muted-foreground line-clamp-2 mb-3">
                                    ${announcement.description}
                                </p>
                                
                                <div class="flex items-center gap-4 text-muted-foreground mb-3">
                                    <div class="flex items-center gap-1">
                                        <i data-lucide="map-pin" class="w-3 h-3"></i>
                                        <span class="text-sm">${announcement.location}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <i data-lucide="clock" class="w-3 h-3"></i>
                                        <span class="text-sm">${announcement.formatted_date}</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <span class="bg-secondary text-secondary-foreground px-2 py-1 rounded text-sm">
                                        ${announcement.category.name}
                                    </span>
                                    <a href="${announcement.show_url}" 
                                       class="text-primary hover:text-primary/80 text-sm font-medium">
                                        Voir plus →
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                });
                html += '</div>';
                container.innerHTML = html;
            } else {
                container.innerHTML = `
                    <div class="text-center py-12">
                        <i data-lucide="search" class="w-16 h-16 text-muted-foreground mx-auto mb-4"></i>
                        <p class="text-muted-foreground text-lg">Aucune annonce trouvée</p>
                        <p class="text-muted-foreground">Essayez de modifier vos critères de recherche</p>
                    </div>
                `;
            }
            
            // Réinitialiser les icônes Lucide
            lucide.createIcons();
            
        } catch (error) {
            console.error('Erreur lors du chargement des annonces:', error);
            container.innerHTML = `
                <div class="text-center py-12">
                    <p class="text-red-500 text-lg">Erreur lors du chargement</p>
                    <p class="text-muted-foreground">Veuillez réessayer</p>
                </div>
            `;
        }
    }
    
    // Gestionnaire d'événement pour les boutons de filtre
    document.getElementById('category-filter').addEventListener('click', function(e) {
        if (e.target.closest('button[data-category]')) {
            e.preventDefault();
            const button = e.target.closest('button[data-category]');
            const category = button.getAttribute('data-category');
            
            // Mettre à jour les classes actives
            document.querySelectorAll('#category-filter button').forEach(btn => {
                btn.classList.remove('bg-primary', 'text-primary-foreground', 'border-primary');
                btn.classList.add('bg-white');
            });
            button.classList.add('bg-primary', 'text-primary-foreground', 'border-primary');
            button.classList.remove('bg-white');
            
            // Mettre à jour l'URL et charger les annonces
            updateURL(category);
            loadAnnouncements(category);
        }
    });
    
    // Gérer le bouton retour/avant du navigateur
    window.addEventListener('popstate', function(event) {
        const params = new URLSearchParams(window.location.search);
        const category = params.get('category') || 'all';
        
        // Mettre à jour les boutons actifs
        document.querySelectorAll('#category-filter button').forEach(btn => {
            btn.classList.remove('bg-primary', 'text-primary-foreground', 'border-primary');
            btn.classList.add('bg-white');
        });
        const activeButton = document.querySelector(`button[data-category="${category}"]`);
        if (activeButton) {
            activeButton.classList.add('bg-primary', 'text-primary-foreground', 'border-primary');
            activeButton.classList.remove('bg-white');
        }
        
        loadAnnouncements(category);
    });
</script>
@endsection
