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
            <p class="text-white/90 mb-8 text-2xl">
                Achetez et vendez tout ce dont vous avez besoin pour vos études : livres, fournitures, 
                savons, vêtements et plus encore. Par des étudiants africains, pour des étudiants africains.
            </p>
            
            <form method="GET" action="{{ route('home') }}" class="flex gap-2 bg-white p-2 rounded-lg shadow-lg max-w-xl">
                <input type="text" 
                       name="search" 
                       placeholder="Rechercher une annonce..." 
                       value="{{ request('search') }}"
                       class="flex-1 border-0 focus:ring-0 px-3 py-2 text-gray-900 placeholder-gray-500 text-lg">
                <button type="submit" class="bg-primary text-primary-foreground px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-2 text-lg">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    Rechercher
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Category Filter -->
{{-- <div class="border-b bg-white">
    <div class="container mx-auto px-4 py-4">
        <div class="flex gap-2 overflow-x-auto" id="category-filter">
            <button data-category="all" 
                    class="px-4 py-2 rounded-lg border border-border hover:bg-muted transition-colors flex items-center gap-2 whitespace-nowrap text-lg {{ !request('category') || request('category') === 'all' ? 'bg-primary text-primary-foreground border-primary' : 'bg-white' }}">
                <i data-lucide="more-horizontal" class="w-4 h-4"></i>
                Toutes
            </button>
            @foreach($categories as $category)
                <button data-category="{{ $category->slug }}" 
                        class="px-4 py-2 rounded-lg border border-border hover:bg-muted transition-colors flex items-center gap-2 whitespace-nowrap text-lg {{ request('category') === $category->slug ? 'bg-primary text-primary-foreground border-primary' : 'bg-white' }}">
                    <i data-lucide="{{ $category->icon }}" class="w-4 h-4"></i>
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    </div>
</div> --}}

<!-- Feature Highlights -->
<section class="border-b border-border bg-gradient-to-b from-slate-50 via-white to-white py-14">
    <div class="container mx-auto px-4">
        <div class="mb-10 flex flex-col gap-3 text-center">
            <span class="mx-auto inline-flex items-center gap-2 rounded-full bg-primary/10 px-4 py-1 text-sm font-semibold text-primary">
                {{-- <i data-lucide="zap" class="h-4 w-4"></i>
                Pourquoi Sanar Market ? --}}
            </span>
            <h3 class="text-3xl font-semibold text-slate-900 md:text-4xl">Un compagnon complet pour les étudiants entre deux cours</h3>
            <p class="mx-auto max-w-3xl text-lg text-muted-foreground">Déposez vos annonces, trouvez ce qu’il vous manque avant un examen et faites vivre l’économie circulaire sur votre campus grâce à des outils pensés pour vous.</p>
        </div>
        <div class="grid gap-6 md:grid-cols-3">
            <div class="group rounded-3xl border border-slate-200 bg-white p-8 shadow-[0_20px_60px_-35px_rgba(15,23,42,0.4)] transition hover:-translate-y-1 hover:border-primary/40 hover:shadow-[0_30px_80px_-40px_rgba(14,116,144,0.45)]">
                <div class="mb-5 inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                    <i data-lucide="megaphone" class="h-7 w-7"></i>
                </div>
                <h4 class="mb-3 text-2xl font-semibold text-slate-900">Publiez en quelques minutes</h4>
                <p class="text-base text-muted-foreground">Ajoutez vos annonces, fixez vos prix et recevez des messages directement via la plateforme pour vendre rapidement à des profils vérifiés.</p>
            </div>
            <div class="group rounded-3xl border border-slate-200 bg-white p-8 shadow-[0_20px_60px_-35px_rgba(15,23,42,0.4)] transition hover:-translate-y-1 hover:border-primary/40 hover:shadow-[0_30px_80px_-40px_rgba(14,116,144,0.45)]">
                <div class="mb-5 inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-600">
                    <i data-lucide="map-pin" class="h-7 w-7"></i>
                </div>
                <h4 class="mb-3 text-2xl font-semibold text-slate-900">100% proche de vous</h4>
                <p class="text-base text-muted-foreground">Filtrez par campus, ville ou catégorie pour dénicher des ressources à deux pas : cours, fournitures, chambres, services et bons plans.</p>
            </div>
            <div class="group rounded-3xl border border-slate-200 bg-white p-8 shadow-[0_20px_60px_-35px_rgba(15,23,42,0.4)] transition hover:-translate-y-1 hover:border-primary/40 hover:shadow-[0_30px_80px_-40px_rgba(14,116,144,0.45)]">
                <div class="mb-5 inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600">
                    <i data-lucide="shield-check" class="h-7 w-7"></i>
                </div>
                <h4 class="mb-3 text-2xl font-semibold text-slate-900">Confiance garantie</h4>
                <p class="text-base text-muted-foreground">Profils vérifiés, annonces modérées et indicateurs de confiance pour vous assurer des transactions sereines dans votre communauté.</p>
            </div>
        </div>
    </div>
</section>

<!-- Category Filter -->
<div class="border-b border-border bg-slate-50/80">
    <div class="container mx-auto px-4 py-4">
        <div class="mb-3 flex items-center justify-between gap-4">
            <p class="text-sm font-semibold uppercase tracking-[0.35em] text-slate-500">Explorer par catégories</p>
            <a href="{{ route('announcements.index') }}" class="hidden items-center gap-2 text-sm font-semibold text-primary hover:text-primary/80 sm:inline-flex">
                Voir toutes les annonces
                <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
            </a>
        </div>
        <div class="flex gap-2 overflow-x-auto pb-2" id="category-filter">
            <button data-category="all" 
                    class="flex items-center gap-2 whitespace-nowrap rounded-full border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/40 {{ !request('category') || request('category') === 'all' ? 'bg-primary text-primary-foreground border-primary shadow-sm shadow-primary/30' : 'hover:bg-white/70 text-slate-500' }}">
                <i data-lucide="more-horizontal" class="h-4 w-4"></i>
                Toutes
            </button>
            @foreach($categories as $category)
                <button data-category="{{ $category->slug }}" 
                        class="flex items-center gap-2 whitespace-nowrap rounded-full border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/40 {{ request('category') === $category->slug ? 'bg-primary text-primary-foreground border-primary shadow-sm shadow-primary/30' : 'hover:bg-white/70 text-slate-500' }}">
                    <i data-lucide="{{ $category->icon }}" class="h-4 w-4"></i>
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container mx-auto px-4 py-12">
    <div class="mb-6" id="announcements-header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            {{-- <div>
                <h2 class="text-4xl font-semibold text-slate-900">
            @if(request('category') && request('category') !== 'all')
                Annonces - {{ $categories->where('slug', request('category'))->first()->name ?? 'Catégorie' }}
            @else
                Toutes les annonces
            @endif
        </h2>
                <p class="text-lg text-muted-foreground">
            {{ $announcements->count() }} annonce{{ $announcements->count() > 1 ? 's' : '' }} 
            disponible{{ $announcements->count() > 1 ? 's' : '' }}
        </p>
            
    </div> --}}

    <div id="announcements-container">
        @if($announcements->count() > 0)
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($announcements as $announcement)
                <a href="{{ route('announcements.show', $announcement) }}" class="group relative overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-[0_20px_60px_-40px_rgba(15,23,42,0.55)] transition hover:-translate-y-1 hover:border-primary/40 hover:shadow-[0_30px_80px_-45px_rgba(14,116,144,0.45)] block">
                    <div class="aspect-video relative overflow-hidden bg-slate-100">
                        <img src="{{ $announcement->image_url }}" 
                             alt="{{ $announcement->title }}"
                             class="h-full w-full object-cover transition duration-500 ease-out group-hover:scale-105">
                        @if($announcement->featured)
                            <div class="absolute left-4 top-4 inline-flex items-center gap-1 rounded-full bg-amber-500/95 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-white shadow-md shadow-amber-500/40">
                                <i data-lucide="star" class="h-3.5 w-3.5"></i>
                                En vedette
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex flex-col gap-4 p-5">
                        <div class="flex items-start justify-between gap-2">
                            <div class="space-y-1">
                                <h3 class="text-xl font-semibold text-slate-900 line-clamp-1">{{ $announcement->title }}</h3>
                                <p class="text-sm font-medium text-primary/80 line-clamp-1">{{ $announcement->category->name }}</p>
                            </div>
                            <p class="rounded-full bg-primary/10 px-3 py-1 text-base font-semibold text-primary whitespace-nowrap">{{ $announcement->price }}</p>
                        </div>
                        
                        <p class="text-base leading-relaxed text-slate-600 line-clamp-3">
                            {{ $announcement->description }}
                        </p>
                        
                        <div class="flex items-center gap-4 text-sm text-muted-foreground">
                    <div class="flex items-center gap-1.5">
                                <i data-lucide="map-pin" class="h-5 w-5"></i>
                                <span class="text-base text-slate-700">{{ $announcement->location }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="clock" class="h-5 w-5"></i>
                                <span class="text-base text-slate-700">{{ $announcement->formatted_date }}</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2">
                            <div class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">
                                <span class="h-2 w-2 rounded-full bg-primary/60"></span>
                                <span>{{ $announcement->category->name }}</span>
                            </div>
                            <span class="inline-flex items-center gap-1 text-sm font-semibold text-primary transition group-hover:text-primary/80">
                                Voir plus
                                <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                            </span>
                        </div>
                    </div>
                </a>
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
    let currentCategory = '{{ request('category', 'all') }}';
    let currentSearch = '{{ request('search', '') }}'.trim();
    
    // Fonction pour mettre à jour l'URL sans recharger
    function updateURL(params) {
        const url = new URL(window.location);
        
        // Réinitialiser les paramètres
        url.searchParams.delete('category');
        url.searchParams.delete('search');
        
        // Ajouter les nouveaux paramètres
        if (params.category && params.category !== 'all') {
            url.searchParams.set('category', params.category);
        }
        if (params.search && params.search.trim && params.search.trim()) {
            url.searchParams.set('search', params.search);
        }
        
        window.history.pushState(params, '', url);
    }
    
    // Fonction pour charger les annonces via AJAX
    async function loadAnnouncements(params = {}) {
        const category = params.category !== undefined ? params.category : currentCategory;
        const search = params.search !== undefined ? params.search : currentSearch;
        
        console.log('Loading announcements:', { category, search });
        
        const url = new URL(window.location.origin + '{{ route("home") }}');
        
        if (category && category !== 'all') {
            url.searchParams.set('category', category);
        }
        if (search && search.trim && search.trim()) {
            url.searchParams.set('search', search);
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
            console.log('Fetching URL:', url.toString());
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            });
            
            const data = await response.json();
            console.log('Received data:', data);
            
            // Mettre à jour le header
            const header = document.getElementById('announcements-header');
            if (search && search.trim && search.trim()) {
                header.querySelector('h2').textContent = `Résultats de recherche`;
            } else {
                header.querySelector('h2').textContent = category === 'all' 
                    ? 'Toutes les annonces' 
                    : `Annonces - ${categories[category]?.name || 'Catégorie'}`;
            }
            header.querySelector('p').textContent = `${data.count} annonce${data.count > 1 ? 's' : ''} disponible${data.count > 1 ? 's' : ''}`;
            
            // Mettre à jour le contenu
            if (data.count > 0) {
                let html = '<div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">';
                data.announcements.forEach(announcement => {
                    html += `
                        <a href="${announcement.show_url}" class="group relative overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-[0_20px_60px_-40px_rgba(15,23,42,0.55)] transition hover:-translate-y-1 hover:border-primary/40 hover:shadow-[0_30px_80px_-45px_rgba(14,116,144,0.45)] block">
                            <div class="aspect-video relative overflow-hidden bg-slate-100">
                                <img src="${announcement.image_url}" 
                                     alt="${announcement.title}"
                                     class="h-full w-full object-cover transition duration-500 ease-out group-hover:scale-105">
                                ${announcement.featured ? `
                                    <div class="absolute left-4 top-4 inline-flex items-center gap-1 rounded-full bg-amber-500/95 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-white shadow-md shadow-amber-500/40">
                                        <i data-lucide="star" class="h-3.5 w-3.5"></i>
                                        En vedette
                                    </div>
                                ` : ''}
                            </div>
                            
                            <div class="flex flex-col gap-4 p-5">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="space-y-1">
                                        <h3 class="text-xl font-semibold text-slate-900 line-clamp-1">${announcement.title}</h3>
                                        <p class="text-sm font-medium text-primary/80 line-clamp-1">${announcement.category.name}</p>
                                    </div>
                                    <p class="rounded-full bg-primary/10 px-3 py-1 text-base font-semibold text-primary whitespace-nowrap">${announcement.price}</p>
                                </div>
                                
                                <p class="text-base leading-relaxed text-slate-600 line-clamp-3">
                                    ${announcement.description}
                                </p>
                                
                                <div class="flex items-center gap-4 text-sm text-muted-foreground">
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="map-pin" class="h-5 w-5"></i>
                                        <span class="text-base text-slate-700">${announcement.location}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="clock" class="h-5 w-5"></i>
                                        <span class="text-base text-slate-700">${announcement.formatted_date}</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between pt-2">
                                    <div class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">
                                        <span class="h-2 w-2 rounded-full bg-primary/60"></span>
                                        <span>${announcement.category.name}</span>
                                    </div>
                                    <span class="inline-flex items-center gap-1 text-sm font-semibold text-primary transition group-hover:text-primary/80">
                                        Voir plus
                                        <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    `;
                });
                html += '</div>';
                container.innerHTML = html;
                console.log('Announcements displayed:', data.count, 'items');
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
    
    // Gestionnaire d'événement pour le formulaire de recherche
    document.getElementById('search-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const searchInput = document.getElementById('search-input');
        const searchValue = searchInput.value.trim();
        currentSearch = searchValue;
        
        console.log('Search submitted:', { category: currentCategory, search: currentSearch });
        
        // Mettre à jour l'URL et charger les annonces
        updateURL({ category: currentCategory, search: currentSearch });
        loadAnnouncements({ category: currentCategory, search: currentSearch });
    });
    
    // Gestionnaire d'événement pour les boutons de filtre
    document.getElementById('category-filter').addEventListener('click', function(e) {
        e.preventDefault();
        if (e.target.closest('button[data-category]')) {
            const button = e.target.closest('button[data-category]');
            const category = button.getAttribute('data-category');
            currentCategory = category;
            
            console.log('Category filter clicked:', { category: currentCategory, search: currentSearch });
            
            // Mettre à jour les classes actives
            document.querySelectorAll('#category-filter button').forEach(btn => {
                btn.classList.remove('bg-primary', 'text-primary-foreground', 'border-primary');
                btn.classList.add('bg-white');
            });
            button.classList.add('bg-primary', 'text-primary-foreground', 'border-primary');
            button.classList.remove('bg-white');
            
            // Mettre à jour l'URL et charger les annonces
            updateURL({ category: currentCategory, search: currentSearch });
            loadAnnouncements({ category: currentCategory, search: currentSearch });
        }
    });
    
    // Gérer le bouton retour/avant du navigateur
    window.addEventListener('popstate', function(event) {
        const params = new URLSearchParams(window.location.search);
        currentCategory = params.get('category') || 'all';
        currentSearch = params.get('search') || '';
        
        // Mettre à jour les boutons actifs
        document.querySelectorAll('#category-filter button').forEach(btn => {
            btn.classList.remove('bg-primary', 'text-primary-foreground', 'border-primary');
            btn.classList.add('bg-white');
        });
        const activeButton = document.querySelector(`button[data-category="${currentCategory}"]`);
        if (activeButton) {
            activeButton.classList.add('bg-primary', 'text-primary-foreground', 'border-primary');
            activeButton.classList.remove('bg-white');
        }
        
        // Mettre à jour le champ de recherche
        document.getElementById('search-input').value = currentSearch;
        
        loadAnnouncements({ category: currentCategory, search: currentSearch });
    });
</script>
@endsection
