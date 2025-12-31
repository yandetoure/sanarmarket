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
                       id="search-input"
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
        @if($campusSpotlights && $campusSpotlights->count() > 0)
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
        @else
            <div class="text-center py-8">
                <i data-lucide="megaphone" class="w-12 h-12 text-slate-400 mx-auto mb-3 opacity-50"></i>
                <p class="text-slate-600 text-sm">Aucune information à la une pour le moment</p>
            </div>
        @endif
    </div>
</section>

<!-- Menu du Jour Restaurants -->
<section class="bg-gradient-to-br from-emerald-50 via-white to-amber-50 border-b border-border py-12">
    <div class="container mx-auto px-4">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-semibold text-slate-900 mb-2 flex items-center gap-3">
                    <div class="p-2 bg-emerald-100 rounded-lg">
                        <i data-lucide="utensils-crossed" class="w-7 h-7 text-emerald-600"></i>
                    </div>
                    Menus du Jour - Restaurants Universitaires
        </h2>
                <p class="text-lg text-slate-600 mt-1">Découvrez les menus du jour des restaurants du campus</p>
            </div>
            <a href="{{ route('campus-restaurant-menu.index') }}" class="hidden items-center gap-2 text-sm font-semibold text-emerald-600 hover:text-emerald-700 sm:inline-flex">
                Voir tous les menus
                <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
            </a>
        </div>
        @if($restau1Dejeuner || $restau1Diner || $restau2Dejeuner || $restau2Diner)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Restau 1 -->
            <div class="bg-white rounded-2xl border-2 border-emerald-200 shadow-lg p-6 hover:shadow-xl transition-shadow">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-3 bg-emerald-100 rounded-xl">
                        <i data-lucide="utensils" class="w-6 h-6 text-emerald-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900">Restau 1</h3>
                </div>
                <div class="space-y-5">
                    @if($restau1Dejeuner)
                        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-4 border border-blue-200">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-full">DÉJEUNER</span>
                                @if($restau1Dejeuner->opening_time && $restau1Dejeuner->closing_time)
                                        <span class="text-sm text-slate-600 flex items-center gap-1">
                                            <i data-lucide="clock" class="w-4 h-4"></i>
                                        {{ \Carbon\Carbon::parse($restau1Dejeuner->opening_time)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($restau1Dejeuner->closing_time)->format('H:i') }}
                                    </span>
                                @endif
                            </div>
                            </div>
                            <div class="flex items-start gap-2">
                                <i data-lucide="chef-hat" class="w-5 h-5 text-blue-600 mt-0.5"></i>
                                <p class="text-base text-slate-800 leading-relaxed font-medium">{{ $restau1Dejeuner->menu_content }}</p>
                            </div>
                        </div>
                    @endif
                    @if($restau1Diner)
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-4 border border-purple-200">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 bg-purple-500 text-white text-xs font-semibold rounded-full">DÎNER</span>
                                @if($restau1Diner->opening_time && $restau1Diner->closing_time)
                                        <span class="text-sm text-slate-600 flex items-center gap-1">
                                            <i data-lucide="clock" class="w-4 h-4"></i>
                                        {{ \Carbon\Carbon::parse($restau1Diner->opening_time)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($restau1Diner->closing_time)->format('H:i') }}
                                    </span>
                                @endif
                            </div>
                            </div>
                            <div class="flex items-start gap-2">
                                <i data-lucide="chef-hat" class="w-5 h-5 text-purple-600 mt-0.5"></i>
                                <p class="text-base text-slate-800 leading-relaxed font-medium">{{ $restau1Diner->menu_content }}</p>
                            </div>
                        </div>
                    @endif
                    @if(!$restau1Dejeuner && !$restau1Diner)
                        <div class="text-center py-8 text-slate-500">
                            <i data-lucide="utensils-crossed" class="w-12 h-12 mx-auto mb-3 opacity-50"></i>
                            <p class="text-sm">Aucun menu disponible pour aujourd'hui</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Restau 2 -->
            <div class="bg-white rounded-2xl border-2 border-amber-200 shadow-lg p-6 hover:shadow-xl transition-shadow">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-3 bg-amber-100 rounded-xl">
                        <i data-lucide="utensils" class="w-6 h-6 text-amber-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900">Restau 2</h3>
                </div>
                <div class="space-y-5">
                    @if($restau2Dejeuner)
                        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-4 border border-blue-200">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-full">DÉJEUNER</span>
                                @if($restau2Dejeuner->opening_time && $restau2Dejeuner->closing_time)
                                        <span class="text-sm text-slate-600 flex items-center gap-1">
                                            <i data-lucide="clock" class="w-4 h-4"></i>
                                        {{ \Carbon\Carbon::parse($restau2Dejeuner->opening_time)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($restau2Dejeuner->closing_time)->format('H:i') }}
                                    </span>
                                @endif
                            </div>
                            </div>
                            <div class="flex items-start gap-2">
                                <i data-lucide="chef-hat" class="w-5 h-5 text-blue-600 mt-0.5"></i>
                                <p class="text-base text-slate-800 leading-relaxed font-medium">{{ $restau2Dejeuner->menu_content }}</p>
                            </div>
                        </div>
                    @endif
                    @if($restau2Diner)
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-4 border border-purple-200">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 bg-purple-500 text-white text-xs font-semibold rounded-full">DÎNER</span>
                                @if($restau2Diner->opening_time && $restau2Diner->closing_time)
                                        <span class="text-sm text-slate-600 flex items-center gap-1">
                                            <i data-lucide="clock" class="w-4 h-4"></i>
                                        {{ \Carbon\Carbon::parse($restau2Diner->opening_time)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($restau2Diner->closing_time)->format('H:i') }}
                                    </span>
                                @endif
                            </div>
                            </div>
                            <div class="flex items-start gap-2">
                                <i data-lucide="chef-hat" class="w-5 h-5 text-purple-600 mt-0.5"></i>
                                <p class="text-base text-slate-800 leading-relaxed font-medium">{{ $restau2Diner->menu_content }}</p>
                            </div>
                        </div>
                    @endif
                    @if(!$restau2Dejeuner && !$restau2Diner)
                        <div class="text-center py-8 text-slate-500">
                            <i data-lucide="utensils-crossed" class="w-12 h-12 mx-auto mb-3 opacity-50"></i>
                            <p class="text-sm">Aucun menu disponible pour aujourd'hui</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @else
            <div class="text-center py-12">
                <i data-lucide="utensils-crossed" class="w-16 h-16 text-slate-400 mx-auto mb-4"></i>
                <p class="text-slate-600 text-lg mb-2">Aucun menu disponible pour aujourd'hui</p>
                <p class="text-slate-500 text-sm">Les menus seront affichés ici une fois qu'ils seront ajoutés</p>
            </div>
        @endif
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

<!-- Infos utiles -->
<section class="bg-gradient-to-br from-sky-50 via-blue-50 to-indigo-50 border-b border-border py-12">
    <div class="container mx-auto px-4">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-semibold text-slate-900 mb-2 flex items-center gap-3">
                    <div class="p-2 bg-sky-100 rounded-lg">
                        <i data-lucide="info" class="w-7 h-7 text-sky-600"></i>
                    </div>
                    Infos Utiles
            </h2>
                <p class="text-lg text-slate-600 mt-1">Informations essentielles pour votre quotidien sur le campus</p>
            </div>
            <a href="{{ route('useful-info.index') }}" class="hidden items-center gap-2 text-sm font-semibold text-sky-600 hover:text-sky-700 sm:inline-flex">
                Voir toutes les infos
                <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if($prayerTimes && $prayerTimes->data)
                <div class="bg-white rounded-2xl border-2 border-sky-200 shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-3 bg-sky-100 rounded-xl">
                            <i data-lucide="clock" class="w-6 h-6 text-sky-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900">Heures de Prière</h3>
                    </div>
                    <div class="grid grid-cols-5 gap-3">
                        <div class="text-center p-3 bg-gradient-to-br from-sky-50 to-blue-50 rounded-xl border border-sky-200">
                            <p class="text-xs font-semibold text-sky-700 mb-2 uppercase">Fajr</p>
                            <p class="text-lg font-bold text-slate-900">{{ $prayerTimes->data['fajr'] ?? '--:--' }}</p>
                        </div>
                        <div class="text-center p-3 bg-gradient-to-br from-sky-50 to-blue-50 rounded-xl border border-sky-200">
                            <p class="text-xs font-semibold text-sky-700 mb-2 uppercase">Dhuhr</p>
                            <p class="text-lg font-bold text-slate-900">{{ $prayerTimes->data['dhuhr'] ?? '--:--' }}</p>
                        </div>
                        <div class="text-center p-3 bg-gradient-to-br from-sky-50 to-blue-50 rounded-xl border border-sky-200">
                            <p class="text-xs font-semibold text-sky-700 mb-2 uppercase">Asr</p>
                            <p class="text-lg font-bold text-slate-900">{{ $prayerTimes->data['asr'] ?? '--:--' }}</p>
                        </div>
                        <div class="text-center p-3 bg-gradient-to-br from-sky-50 to-blue-50 rounded-xl border border-sky-200">
                            <p class="text-xs font-semibold text-sky-700 mb-2 uppercase">Maghrib</p>
                            <p class="text-lg font-bold text-slate-900">{{ $prayerTimes->data['maghrib'] ?? '--:--' }}</p>
                        </div>
                        <div class="text-center p-3 bg-gradient-to-br from-sky-50 to-blue-50 rounded-xl border border-sky-200">
                            <p class="text-xs font-semibold text-sky-700 mb-2 uppercase">Isha</p>
                            <p class="text-lg font-bold text-slate-900">{{ $prayerTimes->data['isha'] ?? '--:--' }}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            @if($universityContacts && $universityContacts->count() > 0)
                <div class="bg-white rounded-2xl border-2 border-sky-200 shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-3 bg-sky-100 rounded-xl">
                            <i data-lucide="phone" class="w-6 h-6 text-sky-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900">Contacts Importants</h3>
                    </div>
                    <div class="space-y-4">
                        @foreach($universityContacts->take(5) as $contact)
                            <div class="p-4 bg-gradient-to-r from-sky-50 to-blue-50 rounded-xl border border-sky-200 hover:border-sky-300 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="p-2 bg-sky-200 rounded-lg">
                                        <i data-lucide="phone-call" class="w-4 h-4 text-sky-700"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-bold text-slate-900 mb-1">{{ $contact->title }}</p>
                                        <p class="text-sm text-slate-700 leading-relaxed">{{ Str::limit($contact->content, 100) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        @if(!$prayerTimes && (!$universityContacts || $universityContacts->count() === 0))
            <div class="text-center py-12">
                <i data-lucide="info" class="w-16 h-16 text-slate-400 mx-auto mb-4"></i>
                <p class="text-slate-600 text-lg">Aucune information disponible pour le moment</p>
            </div>
        @endif
    </div>
</section>

<!-- Événements à venir -->
<section class="bg-gradient-to-br from-purple-50 via-pink-50 to-rose-50 border-b border-border py-12">
    <div class="container mx-auto px-4">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-semibold text-slate-900 mb-2 flex items-center gap-3">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <i data-lucide="calendar" class="w-7 h-7 text-purple-600"></i>
                    </div>
                    Événements à Venir
                </h2>
                <p class="text-lg text-slate-600 mt-1">Ne manquez pas les prochains événements du campus</p>
            </div>
            <a href="{{ route('events.index') }}" class="hidden items-center gap-2 text-sm font-semibold text-purple-600 hover:text-purple-700 sm:inline-flex">
                Voir tous les événements
                <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
            </a>
        </div>
        @if($upcomingEvents && $upcomingEvents->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($upcomingEvents as $event)
                <a href="{{ route('events.show', $event) }}" class="group bg-white rounded-2xl border-2 border-purple-200 shadow-lg overflow-hidden hover:shadow-xl hover:border-purple-300 transition-all block">
                    @if($event->image)
                        <div class="aspect-video relative overflow-hidden bg-slate-100">
                            <img src="{{ asset('storage/' . $event->image) }}" 
                                 alt="{{ $event->title }}"
                                 class="h-full w-full object-cover transition duration-500 ease-out group-hover:scale-110">
                        </div>
                    @else
                        <div class="aspect-video relative overflow-hidden bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
                            <i data-lucide="calendar" class="w-16 h-16 text-purple-400"></i>
                        </div>
                    @endif
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-slate-900 mb-3 line-clamp-2 group-hover:text-purple-600 transition-colors">{{ $event->title }}</h3>
                        <p class="text-sm text-slate-600 mb-4 line-clamp-2">{{ $event->description }}</p>
                        <div class="flex items-center gap-4 text-sm">
                            <div class="flex items-center gap-2 text-purple-600">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                <span class="font-semibold">{{ $event->start_date->format('d/m/Y') }}</span>
                            </div>
                            @if($event->location)
                                <div class="flex items-center gap-2 text-slate-600">
                                    <i data-lucide="map-pin" class="w-4 h-4"></i>
                                    <span class="line-clamp-1">{{ $event->location }}</span>
                                </div>
                            @endif
                        </div>
                        @if($event->start_date->format('H:i') !== '00:00')
                            <div class="mt-3 flex items-center gap-2 text-sm text-purple-600">
                                <i data-lucide="clock" class="w-4 h-4"></i>
                                <span>{{ $event->start_date->format('H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
        @else
            <div class="text-center py-12">
                <i data-lucide="calendar" class="w-16 h-16 text-slate-400 mx-auto mb-4"></i>
                <p class="text-slate-600 text-lg mb-2">Aucun événement à venir pour le moment</p>
                <p class="text-slate-500 text-sm">Les prochains événements du campus seront affichés ici</p>
            </div>
@endif
    </div>
</section>

<!-- Annonces à la une -->
@if($featuredAnnouncements && $featuredAnnouncements->count() > 0)
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

<!-- Feature Highlights -->
<section class="border-b border-border bg-gradient-to-b from-slate-50 via-white to-white py-14">
    <div class="container mx-auto px-4">
        <div class="mb-10 flex flex-col gap-3 text-center">
            <h3 class="text-3xl font-semibold text-slate-900 md:text-4xl">Un compagnon complet pour les étudiants entre deux cours</h3>
            <p class="mx-auto max-w-3xl text-lg text-muted-foreground">Déposez vos annonces, trouvez ce qu'il vous manque avant un examen et faites vivre l'économie circulaire sur votre campus grâce à des outils pensés pour vous.</p>
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

<!-- Main Content -->
<div class="container mx-auto px-4 py-12">
    <div class="mb-6" id="announcements-header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-4xl font-semibold text-slate-900">Toutes les annonces</h2>
                <p class="text-lg text-muted-foreground mt-2">
            {{ $announcements->count() }} annonce{{ $announcements->count() > 1 ? 's' : '' }} 
            disponible{{ $announcements->count() > 1 ? 's' : '' }}
        </p>
            </div>
        </div>
    </div>

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
    
    // Variable globale pour stocker la recherche
    let currentSearch = '{{ request('search', '') }}'.trim();
    
    // Fonction pour mettre à jour l'URL sans recharger
    function updateURL(search) {
        const url = new URL(window.location);
        
        // Réinitialiser le paramètre de recherche
        url.searchParams.delete('search');
        
        // Ajouter le nouveau paramètre
        if (search && search.trim && search.trim()) {
            url.searchParams.set('search', search);
        }
        
        window.history.pushState({ search }, '', url);
    }
    
    // Fonction pour charger les annonces via AJAX
    async function loadAnnouncements(search = '') {
        const url = new URL(window.location.origin + '{{ route("home") }}');
        
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
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            });
            
            const data = await response.json();
            
            // Mettre à jour le header
            const header = document.getElementById('announcements-header');
            if (header) {
                const headerDiv = header.querySelector('div');
                if (headerDiv) {
                    const h2 = headerDiv.querySelector('h2');
                    const p = headerDiv.querySelector('p');
                    if (h2) {
                        h2.textContent = search && search.trim() ? 'Résultats de recherche' : 'Toutes les annonces';
                    }
                    if (p) {
                        p.textContent = `${data.count} annonce${data.count > 1 ? 's' : ''} disponible${data.count > 1 ? 's' : ''}`;
                    }
                }
            }
            
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
            const container = document.getElementById('announcements-container');
            container.innerHTML = `
                <div class="text-center py-12">
                    <p class="text-red-500 text-lg">Erreur lors du chargement</p>
                    <p class="text-muted-foreground">Veuillez réessayer</p>
                </div>
            `;
        }
    }
    
    // Gestionnaire d'événement pour le formulaire de recherche
    const searchForm = document.querySelector('form[method="GET"][action="{{ route('home') }}"]');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
            const searchInput = this.querySelector('input[name="search"]');
        const searchValue = searchInput.value.trim();
        currentSearch = searchValue;
            
            // Mettre à jour l'URL et charger les annonces
            updateURL(currentSearch);
            loadAnnouncements(currentSearch);
        });
        }
    
    // Gérer le bouton retour/avant du navigateur
    window.addEventListener('popstate', function(event) {
        const params = new URLSearchParams(window.location.search);
        currentSearch = params.get('search') || '';
        
        // Mettre à jour le champ de recherche
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            searchInput.value = currentSearch;
        }
        
        loadAnnouncements(currentSearch);
    });
</script>
@endsection

