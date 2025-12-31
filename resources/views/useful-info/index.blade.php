@extends('layouts.app')

@section('title', 'Infos utiles - Sanar Market')

@section('content')
<style>
    .page-with-sidebar {
        display: flex;
        gap: 2rem;
        align-items: flex-start;
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }
    .sidebar-nav {
        width: 260px;
        background: #fff;
        border-radius: 1rem;
        border: 1px solid rgba(15,23,42,0.08);
        padding: 1.5rem;
        box-shadow: 0 25px 60px -45px rgba(9,12,30,0.65);
        position: sticky;
        top: 100px;
        height: fit-content;
    }
    .sidebar-nav h3 {
        margin-bottom: 1rem;
        font-size: 0.875rem;
        color: #0f172a;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-weight: 600;
    }
    .sidebar-nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .sidebar-nav a {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-decoration: none;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        color: #475569;
        font-weight: 500;
        transition: all 0.2s;
        border: 1px solid transparent;
    }
    .sidebar-nav a:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .sidebar-nav a.active {
        background: #0f75ff;
        color: #fff;
        border-color: #0f75ff;
    }
    .sidebar-nav a i {
        width: 1.25rem;
        height: 1.25rem;
    }
    .main-content-area {
        flex: 1;
        min-width: 0;
    }
    @media (max-width: 1023px) {
        .page-with-sidebar {
            flex-direction: column;
        }
        .sidebar-nav {
            width: 100%;
            position: relative;
            top: 0;
        }
    }
</style>

<div class="page-with-sidebar">
    <!-- Sidebar Navigation -->
    <aside class="sidebar-nav">
        <h3>Navigation</h3>
        <ul>
            <li>
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    <i data-lucide="home"></i>
                    <span>Accueil</span>
                </a>
            </li>
            <li>
                <a href="{{ route('announcements.index') }}" class="{{ request()->routeIs('announcements.*') ? 'active' : '' }}">
                    <i data-lucide="megaphone"></i>
                    <span>Annonces</span>
                </a>
            </li>
            <li>
                <a href="{{ route('boutiques.index') }}" class="{{ request()->routeIs('boutiques.*') ? 'active' : '' }}">
                    <i data-lucide="store"></i>
                    <span>Boutiques</span>
                </a>
            </li>
            <li>
                <a href="{{ route('restaurants.index') }}" class="{{ request()->routeIs('restaurants.*') ? 'active' : '' }}">
                    <i data-lucide="utensils-crossed"></i>
                    <span>Restaurants</span>
                </a>
            </li>
            <li>
                <a href="{{ route('useful-info.index') }}" class="{{ request()->routeIs('useful-info.*') ? 'active' : '' }}">
                    <i data-lucide="info"></i>
                    <span>Infos utiles</span>
                </a>
            </li>
            <li>
                <a href="{{ route('forum.index') }}" class="{{ request()->routeIs('forum.index') || request()->routeIs('forum.show') || request()->routeIs('forum.create') ? 'active' : '' }}">
                    <i data-lucide="message-square"></i>
                    <span>Forum</span>
                </a>
            </li>
            <li>
                <a href="{{ route('forum.groups.index') }}" class="{{ request()->routeIs('forum.groups.*') ? 'active' : '' }}">
                    <i data-lucide="users"></i>
                    <span>Groupes</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="main-content-area">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Infos utiles</h1>
            <p class="text-muted-foreground">
                Toutes les informations pratiques pour votre vie sur le campus
            </p>
        </div>

        <div class="space-y-8">
        <!-- Heures de prière -->
        <section class="bg-white rounded-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-semibold text-slate-900 flex items-center gap-2">
                    <i data-lucide="clock" class="w-6 h-6 text-primary"></i>
                    Heures de prière
                </h2>
                @auth
                    @if(auth()->user()->isAmbassador())
                        <button onclick="document.getElementById('prayer-times-form').classList.toggle('hidden')" 
                                class="text-sm text-primary hover:text-primary/80 font-semibold">
                            Modifier
                        </button>
                    @endif
                @endauth
            </div>

            @auth
                @if(auth()->user()->isAmbassador())
                    <form id="prayer-times-form" action="{{ route('useful-info.prayer-times') }}" method="POST" class="hidden mb-4 bg-slate-50 p-4 rounded-lg">
                        @csrf
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-1">Fajr</label>
                                <input type="time" name="data[fajr]" value="{{ $prayerTimes->data['fajr'] ?? '' }}" class="w-full px-3 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Dhuhr</label>
                                <input type="time" name="data[dhuhr]" value="{{ $prayerTimes->data['dhuhr'] ?? '' }}" class="w-full px-3 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Asr</label>
                                <input type="time" name="data[asr]" value="{{ $prayerTimes->data['asr'] ?? '' }}" class="w-full px-3 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Maghrib</label>
                                <input type="time" name="data[maghrib]" value="{{ $prayerTimes->data['maghrib'] ?? '' }}" class="w-full px-3 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Isha</label>
                                <input type="time" name="data[isha]" value="{{ $prayerTimes->data['isha'] ?? '' }}" class="w-full px-3 py-2 border rounded">
                            </div>
                        </div>
                        <button type="submit" class="mt-4 bg-primary text-white px-4 py-2 rounded hover:bg-primary/90">
                            Enregistrer
                        </button>
                    </form>
                @endif
            @endauth

            @if($prayerTimes && $prayerTimes->data)
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <div class="text-center p-4 bg-slate-50 rounded-lg">
                        <p class="text-sm text-slate-600 mb-1">Fajr</p>
                        <p class="text-xl font-semibold text-slate-900">{{ $prayerTimes->data['fajr'] ?? '--:--' }}</p>
                    </div>
                    <div class="text-center p-4 bg-slate-50 rounded-lg">
                        <p class="text-sm text-slate-600 mb-1">Dhuhr</p>
                        <p class="text-xl font-semibold text-slate-900">{{ $prayerTimes->data['dhuhr'] ?? '--:--' }}</p>
                    </div>
                    <div class="text-center p-4 bg-slate-50 rounded-lg">
                        <p class="text-sm text-slate-600 mb-1">Asr</p>
                        <p class="text-xl font-semibold text-slate-900">{{ $prayerTimes->data['asr'] ?? '--:--' }}</p>
                    </div>
                    <div class="text-center p-4 bg-slate-50 rounded-lg">
                        <p class="text-sm text-slate-600 mb-1">Maghrib</p>
                        <p class="text-xl font-semibold text-slate-900">{{ $prayerTimes->data['maghrib'] ?? '--:--' }}</p>
                    </div>
                    <div class="text-center p-4 bg-slate-50 rounded-lg">
                        <p class="text-sm text-slate-600 mb-1">Isha</p>
                        <p class="text-xl font-semibold text-slate-900">{{ $prayerTimes->data['isha'] ?? '--:--' }}</p>
                    </div>
                </div>
                <p class="text-xs text-slate-500 mt-4 text-center">Référence: Grande Mosquée de l'UGB</p>
            @else
                <p class="text-slate-500">Les heures de prière ne sont pas encore configurées.</p>
            @endif
        </section>

        <!-- Contacts des services de l'université -->
        <section class="bg-white rounded-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-semibold text-slate-900 flex items-center gap-2">
                    <i data-lucide="phone" class="w-6 h-6 text-primary"></i>
                    Contacts des services de l'université
                </h2>
                @auth
                    @if(auth()->user()->isAmbassador())
                        <button onclick="document.getElementById('contact-form').classList.toggle('hidden')" 
                                class="text-sm text-primary hover:text-primary/80 font-semibold">
                            Ajouter
                        </button>
                    @endif
                @endauth
            </div>

            @auth
                @if(auth()->user()->isAmbassador())
                    <form id="contact-form" action="{{ route('useful-info.university-contact') }}" method="POST" class="hidden mb-4 bg-slate-50 p-4 rounded-lg">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold mb-1">Service *</label>
                                <input type="text" name="title" required class="w-full px-3 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Contact *</label>
                                <textarea name="content" rows="3" required class="w-full px-3 py-2 border rounded" placeholder="Téléphone, email, adresse..."></textarea>
                            </div>
                            <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary/90">
                                Ajouter
                            </button>
                        </div>
                    </form>
                @endif
            @endauth

            @if($universityContacts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($universityContacts as $contact)
                        <div class="p-4 bg-slate-50 rounded-lg">
                            <h3 class="font-semibold text-slate-900 mb-2">{{ $contact->title }}</h3>
                            <p class="text-sm text-slate-600 whitespace-pre-line">{{ $contact->content }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-slate-500">Aucun contact disponible.</p>
            @endif
        </section>

        <!-- Pharmacie de garde -->
        <section class="bg-white rounded-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-semibold text-slate-900 flex items-center gap-2">
                    <i data-lucide="pill" class="w-6 h-6 text-primary"></i>
                    Pharmacie de garde de Saint-Louis
                </h2>
                @auth
                    @if(auth()->user()->isAmbassador())
                        <form action="{{ route('useful-info.pharmacy-on-duty') }}" method="POST" enctype="multipart/form-data" class="inline">
                            @csrf
                            <input type="file" name="image" accept="image/*" required onchange="this.form.submit()" class="hidden" id="pharmacy-upload">
                            <label for="pharmacy-upload" class="text-sm text-primary hover:text-primary/80 font-semibold cursor-pointer">
                                Modifier l'affiche
                            </label>
                        </form>
                    @endif
                @endauth
            </div>

            @if($pharmacyOnDuty && $pharmacyOnDuty->image)
                <div class="flex justify-center">
                    <img src="{{ asset('storage/' . $pharmacyOnDuty->image) }}" 
                         alt="Pharmacie de garde" 
                         class="max-w-full h-auto rounded-lg shadow-md">
                </div>
            @else
                <p class="text-slate-500">L'affiche de pharmacie de garde n'est pas encore disponible.</p>
            @endif
        </section>

        <!-- Plan du campus -->
        <section class="bg-white rounded-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-semibold text-slate-900 flex items-center gap-2">
                    <i data-lucide="map" class="w-6 h-6 text-primary"></i>
                    Plan du campus
                </h2>
                @auth
                    @if(auth()->user()->isAmbassador())
                        <form action="{{ route('useful-info.campus-map') }}" method="POST" enctype="multipart/form-data" class="inline">
                            @csrf
                            <input type="file" name="image" accept="image/*" required onchange="this.form.submit()" class="hidden" id="map-upload">
                            <label for="map-upload" class="text-sm text-primary hover:text-primary/80 font-semibold cursor-pointer">
                                Modifier le plan
                            </label>
                        </form>
                    @endif
                @endauth
            </div>

            @if($campusMap && $campusMap->image)
                <div class="flex justify-center">
                    <img src="{{ asset('storage/' . $campusMap->image) }}" 
                         alt="Plan du campus" 
                         class="max-w-full h-auto rounded-lg shadow-md">
                </div>
            @else
                <p class="text-slate-500">Le plan du campus n'est pas encore disponible.</p>
            @endif
        </section>

        <!-- Contacter le support -->
        <section class="bg-white rounded-lg border border-slate-200 p-6">
            <h2 class="text-2xl font-semibold text-slate-900 mb-4 flex items-center gap-2">
                <i data-lucide="message-circle" class="w-6 h-6 text-primary"></i>
                Contacter le support
            </h2>
            <p class="text-slate-600 mb-4">Besoin d'aide ? Contactez-nous via WhatsApp</p>
            <a href="https://wa.me/221772319878" 
               target="_blank"
               rel="noopener noreferrer"
               class="inline-flex items-center gap-2 bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-colors">
                <i data-lucide="message-circle" class="w-5 h-5"></i>
                Ouvrir WhatsApp
            </a>
        </section>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection

