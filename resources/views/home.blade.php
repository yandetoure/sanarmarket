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

<!-- À la une au campus -->
@if(isset($campusSpotlights) && $campusSpotlights->count() > 0)
<section class="bg-gradient-to-r from-primary/10 via-primary/5 to-transparent border-b border-border py-8">
    <div class="container mx-auto px-4">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-slate-900 flex items-center gap-2">
                <i data-lucide="megaphone" class="w-6 h-6 text-primary"></i>
                À la une au campus
            </h2>
            @auth
                @if(auth()->user()->isAmbassador())
                    <a href="{{ route('campus-spotlight.index') }}" class="text-sm text-primary hover:text-primary/80 font-semibold">
                        Gérer
                    </a>
                @endif
            @endauth
        </div>
        <div class="space-y-3">
            @foreach($campusSpotlights as $spotlight)
                <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="flex-1">
                            <h3 class="font-semibold text-lg text-slate-900 mb-1">{{ $spotlight->title }}</h3>
                            <p class="text-slate-600 text-sm">{{ $spotlight->content }}</p>
                            <p class="text-xs text-slate-400 mt-2">{{ $spotlight->published_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Menu du Jour Restaurants -->
<section class="bg-white border-b border-border py-8">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-semibold text-slate-900 mb-6 flex items-center gap-2">
            <i data-lucide="utensils-crossed" class="w-6 h-6 text-primary"></i>
            Menu du Jour
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Restau 1 -->
            <div class="bg-slate-50 rounded-lg border border-slate-200 p-6">
                <h3 class="text-xl font-semibold text-slate-900 mb-4">Restau 1</h3>
                <div class="space-y-4">
                    @if(isset($restau1Dejeuner) && $restau1Dejeuner)
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-semibold text-slate-700">Déjeuner</h4>
                                @if($restau1Dejeuner->opening_time && $restau1Dejeuner->closing_time)
                                    <span class="text-xs text-slate-500">
                                        {{ \Carbon\Carbon::parse($restau1Dejeuner->opening_time)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($restau1Dejeuner->closing_time)->format('H:i') }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm text-slate-600">{{ $restau1Dejeuner->menu_content }}</p>
                        </div>
                    @endif
                    @if(isset($restau1Diner) && $restau1Diner)
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-semibold text-slate-700">Dîner</h4>
                                @if($restau1Diner->opening_time && $restau1Diner->closing_time)
                                    <span class="text-xs text-slate-500">
                                        {{ \Carbon\Carbon::parse($restau1Diner->opening_time)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($restau1Diner->closing_time)->format('H:i') }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm text-slate-600">{{ $restau1Diner->menu_content }}</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Restau 2 -->
            <div class="bg-slate-50 rounded-lg border border-slate-200 p-6">
                <h3 class="text-xl font-semibold text-slate-900 mb-4">Restau 2</h3>
                <div class="space-y-4">
                    @if(isset($restau2Dejeuner) && $restau2Dejeuner)
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-semibold text-slate-700">Déjeuner</h4>
                                @if($restau2Dejeuner->opening_time && $restau2Dejeuner->closing_time)
                                    <span class="text-xs text-slate-500">
                                        {{ \Carbon\Carbon::parse($restau2Dejeuner->opening_time)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($restau2Dejeuner->closing_time)->format('H:i') }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm text-slate-600">{{ $restau2Dejeuner->menu_content }}</p>
                        </div>
                    @endif
                    @if(isset($restau2Diner) && $restau2Diner)
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-semibold text-slate-700">Dîner</h4>
                                @if($restau2Diner->opening_time && $restau2Diner->closing_time)
                                    <span class="text-xs text-slate-500">
                                        {{ \Carbon\Carbon::parse($restau2Diner->opening_time)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($restau2Diner->closing_time)->format('H:i') }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm text-slate-600">{{ $restau2Diner->menu_content }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Accès rapide -->
<section class="bg-slate-50 border-b border-border py-8">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-semibold text-slate-900 mb-6 flex items-center gap-2">
            <i data-lucide="zap" class="w-6 h-6 text-primary"></i>
            Accès rapide
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('announcements.index') }}" class="bg-white rounded-lg border border-slate-200 p-4 text-center hover:border-primary/40 hover:shadow-md transition-all group">
                <i data-lucide="megaphone" class="w-8 h-8 text-primary mx-auto mb-2 group-hover:scale-110 transition-transform"></i>
                <p class="font-semibold text-slate-900">Annonces</p>
            </a>
            <a href="{{ route('boutiques.index') }}" class="bg-white rounded-lg border border-slate-200 p-4 text-center hover:border-primary/40 hover:shadow-md transition-all group">
                <i data-lucide="store" class="w-8 h-8 text-primary mx-auto mb-2 group-hover:scale-110 transition-transform"></i>
                <p class="font-semibold text-slate-900">Commerces</p>
            </a>
            <a href="{{ route('events.index') }}" class="bg-white rounded-lg border border-slate-200 p-4 text-center hover:border-primary/40 hover:shadow-md transition-all group">
                <i data-lucide="calendar" class="w-8 h-8 text-primary mx-auto mb-2 group-hover:scale-110 transition-transform"></i>
                <p class="font-semibold text-slate-900">Événements</p>
            </a>
            <a href="{{ route('useful-info.index') }}" class="bg-white rounded-lg border border-slate-200 p-4 text-center hover:border-primary/40 hover:shadow-md transition-all group">
                <i data-lucide="info" class="w-8 h-8 text-primary mx-auto mb-2 group-hover:scale-110 transition-transform"></i>
                <p class="font-semibold text-slate-900">Infos utiles</p>
            </a>
        </div>
    </div>
</section>

<!-- Infos utiles (aperçu) -->
@if(isset($prayerTimes) || (isset($universityContacts) && $universityContacts->count() > 0))
<section class="bg-gradient-to-br from-slate-50 to-white border-b border-border py-8">
    <div class="container mx-auto px-4">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-slate-900 flex items-center gap-2">
                <i data-lucide="info" class="w-6 h-6 text-primary"></i>
                Infos utiles
            </h2>
            <a href="{{ route('useful-info.index') }}" class="text-sm text-primary hover:text-primary/80 font-semibold">
                Voir toutes les infos
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if(isset($prayerTimes) && $prayerTimes->data)
                <div class="bg-white rounded-lg border border-slate-200 p-6">
                    <h3 class="font-semibold text-lg text-slate-900 mb-4 flex items-center gap-2">
                        <i data-lucide="clock" class="w-5 h-5 text-primary"></i>
                        Heures de prière
                    </h3>
                    <div class="grid grid-cols-5 gap-2">
                        <div class="text-center">
                            <p class="text-xs text-slate-600 mb-1">Fajr</p>
                            <p class="font-semibold text-slate-900">{{ $prayerTimes->data['fajr'] ?? '--:--' }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-slate-600 mb-1">Dhuhr</p>
                            <p class="font-semibold text-slate-900">{{ $prayerTimes->data['dhuhr'] ?? '--:--' }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-slate-600 mb-1">Asr</p>
                            <p class="font-semibold text-slate-900">{{ $prayerTimes->data['asr'] ?? '--:--' }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-slate-600 mb-1">Maghrib</p>
                            <p class="font-semibold text-slate-900">{{ $prayerTimes->data['maghrib'] ?? '--:--' }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-slate-600 mb-1">Isha</p>
                            <p class="font-semibold text-slate-900">{{ $prayerTimes->data['isha'] ?? '--:--' }}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            @if(isset($universityContacts) && $universityContacts->count() > 0)
                <div class="bg-white rounded-lg border border-slate-200 p-6">
                    <h3 class="font-semibold text-lg text-slate-900 mb-4 flex items-center gap-2">
                        <i data-lucide="phone" class="w-5 h-5 text-primary"></i>
                        Contacts importants
                    </h3>
                    <div class="space-y-3">
                        @foreach($universityContacts->take(3) as $contact)
                            <div>
                                <p class="font-semibold text-slate-900 text-sm">{{ $contact->title }}</p>
                                <p class="text-xs text-slate-600 line-clamp-2">{{ $contact->content }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Annonces à la une -->
@if(isset($featuredAnnouncements) && $featuredAnnouncements->count() > 0)
<section class="bg-white border-b border-border py-8">
    <div class="container mx-auto px-4">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-slate-900 flex items-center gap-2">
                <i data-lucide="star" class="w-6 h-6 text-amber-500"></i>
                Annonces à la une
            </h2>
            <a href="{{ route('announcements.index') }}" class="text-sm text-primary hover:text-primary/80 font-semibold">
                Voir toutes les annonces
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($featuredAnnouncements as $announcement)
                <a href="{{ route('announcements.show', $announcement) }}" class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-primary/40 hover:shadow-md block">
                    <div class="aspect-video relative overflow-hidden bg-slate-100">
                        <img src="{{ $announcement->image_url }}" 
                             alt="{{ $announcement->title }}"
                             class="h-full w-full object-cover transition duration-500 ease-out group-hover:scale-105">
                        <div class="absolute left-3 top-3 inline-flex items-center gap-1 rounded-full bg-amber-500/95 px-2 py-1 text-xs font-semibold uppercase tracking-wider text-white">
                            <i data-lucide="star" class="h-3 w-3"></i>
                            En vedette
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-slate-900 line-clamp-1 mb-1">{{ $announcement->title }}</h3>
                        <p class="text-sm text-primary/80 mb-2">{{ $announcement->category->name }}</p>
                        <p class="text-base font-semibold text-primary">{{ $announcement->price }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

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

<!-- Articles de Boutique -->
@if($boutiqueArticles->count() > 0)
<section class="border-t border-border bg-slate-50/50 py-12">
    <div class="container mx-auto px-4">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-semibold text-slate-900">Articles de Boutique</h2>
                <p class="text-lg text-muted-foreground mt-1">Découvrez nos produits disponibles</p>
            </div>
            <a href="{{ route('boutiques.index') }}" class="hidden items-center gap-2 text-sm font-semibold text-primary hover:text-primary/80 sm:inline-flex">
                Voir toutes les boutiques
                <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($boutiqueArticles as $article)
                <a href="{{ route('boutiques.public.show', $article->boutique) }}" class="group relative overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-[0_20px_60px_-40px_rgba(15,23,42,0.55)] transition hover:-translate-y-1 hover:border-primary/40 hover:shadow-[0_30px_80px_-45px_rgba(14,116,144,0.45)] block">
                    <div class="aspect-video relative overflow-hidden bg-slate-100">
                        @if($article->image)
                            <img src="{{ asset('storage/' . $article->image) }}" 
                                 alt="{{ $article->name }}"
                                 class="h-full w-full object-cover transition duration-500 ease-out group-hover:scale-105">
                        @else
                            <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-primary/10 to-primary/5">
                                <i data-lucide="package" class="w-16 h-16 text-primary/40"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex flex-col gap-4 p-5">
                        <div class="flex items-start justify-between gap-2">
                            <div class="space-y-1">
                                <h3 class="text-xl font-semibold text-slate-900 line-clamp-1">{{ $article->name }}</h3>
                                <p class="text-sm font-medium text-primary/80 line-clamp-1">{{ $article->boutique->name }}</p>
                                @if($article->category)
                                    <p class="text-xs text-slate-500">{{ $article->category->name }}</p>
                                @endif
                            </div>
                            <p class="rounded-full bg-primary/10 px-3 py-1 text-base font-semibold text-primary whitespace-nowrap">{{ number_format($article->price, 0, ',', ' ') }} FCFA</p>
                        </div>
                        
                        @if($article->description)
                        <p class="text-base leading-relaxed text-slate-600 line-clamp-2">
                            {{ $article->description }}
                        </p>
                        @endif
                        
                        <div class="flex items-center gap-4 text-sm text-muted-foreground">
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="package" class="h-5 w-5"></i>
                                <span class="text-base text-slate-700">Stock: {{ $article->stock }}</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2">
                            <div class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">
                                <span class="h-2 w-2 rounded-full bg-primary/60"></span>
                                <span>Boutique</span>
                            </div>
                            <span class="inline-flex items-center gap-1 text-sm font-semibold text-primary transition group-hover:text-primary/80">
                                Voir la boutique
                                <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Menus de Restaurant -->
@if($restaurantMenuItems->count() > 0)
<section class="border-t border-border bg-white py-12">
    <div class="container mx-auto px-4">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-semibold text-slate-900">Menus de Restaurant</h2>
                <p class="text-lg text-muted-foreground mt-1">Découvrez nos plats disponibles</p>
            </div>
            <a href="{{ route('restaurants.index') }}" class="hidden items-center gap-2 text-sm font-semibold text-primary hover:text-primary/80 sm:inline-flex">
                Voir tous les restaurants
                <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($restaurantMenuItems as $menuItem)
                <a href="{{ route('restaurants.public.show', $menuItem->restaurant) }}" class="group relative overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-[0_20px_60px_-40px_rgba(15,23,42,0.55)] transition hover:-translate-y-1 hover:border-primary/40 hover:shadow-[0_30px_80px_-45px_rgba(14,116,144,0.45)] block">
                    <div class="aspect-video relative overflow-hidden bg-slate-100">
                        <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-amber-100 to-orange-50">
                            <i data-lucide="utensils-crossed" class="w-16 h-16 text-amber-400"></i>
                        </div>
                    </div>
                    
                    <div class="flex flex-col gap-4 p-5">
                        <div class="flex items-start justify-between gap-2">
                            <div class="space-y-1">
                                <h3 class="text-xl font-semibold text-slate-900 line-clamp-1">{{ $menuItem->title }}</h3>
                                <p class="text-sm font-medium text-primary/80 line-clamp-1">{{ $menuItem->restaurant->name }}</p>
                            </div>
                            <p class="rounded-full bg-primary/10 px-3 py-1 text-base font-semibold text-primary whitespace-nowrap">{{ number_format($menuItem->price, 0, ',', ' ') }} FCFA</p>
                        </div>
                        
                        @if($menuItem->description)
                        <p class="text-base leading-relaxed text-slate-600 line-clamp-2">
                            {{ $menuItem->description }}
                        </p>
                        @endif
                        
                        <div class="flex items-center gap-4 text-sm text-muted-foreground">
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="check-circle" class="h-5 w-5 text-green-500"></i>
                                <span class="text-base text-slate-700">Disponible</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2">
                            <div class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">
                                <span class="h-2 w-2 rounded-full bg-amber-500/60"></span>
                                <span>Restaurant</span>
                            </div>
                            <span class="inline-flex items-center gap-1 text-sm font-semibold text-primary transition group-hover:text-primary/80">
                                Voir le restaurant
                                <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- WhatsApp Floating Button -->
<a href="https://wa.me/221772319878" 
   target="_blank"
   rel="noopener noreferrer"
   id="whatsapp-float"
   class="fixed bottom-6 right-6 text-white rounded-full p-3 shadow-2xl hover:shadow-[0_10px_30px_rgba(37,211,102,0.4)] transition-all duration-300 flex items-center justify-center w-14 h-14"
   aria-label="Contactez-nous sur WhatsApp"
   style="z-index: 99999; position: fixed; background-color: #25D366;">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6" style="fill: white;">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
    </svg>
</a>

<style>
    /* Animation de bounce pour attirer l'attention */
    @keyframes bounce-whatsapp {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-8px);
        }
    }
    
    @keyframes pulse-whatsapp {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
        }
        50% {
            box-shadow: 0 0 0 12px rgba(37, 211, 102, 0);
        }
    }
    
    #whatsapp-float {
        animation: bounce-whatsapp 2s ease-in-out infinite, pulse-whatsapp 2s ease-in-out infinite;
        z-index: 99999 !important;
        position: fixed !important;
        bottom: 1.5rem !important;
        right: 1.5rem !important;
        background-color: #25D366 !important;
        border: 2px solid #128C7E !important;
    }
    
    #whatsapp-float:hover {
        animation: bounce-whatsapp 0.5s ease-in-out infinite, none;
        transform: translateY(-5px) scale(1.1);
        background-color: #20BA5A !important;
    }
</style>
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
