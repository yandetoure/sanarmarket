@extends('layouts.app')

@section('title', 'Mon espace - Sanar Market')

@section('content')
<style>
    .user-dashboard-hero {
        background: linear-gradient(135deg,#0f172a,#1d2a50);
        color: #f7f9ff;
        padding: 48px 0;
    }
    .user-dashboard-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 24px;
    }
    .user-dashboard-hero h1 {
        font-size: clamp(2rem, 4vw, 2.8rem);
        margin-bottom: 10px;
        font-weight: 600;
    }
    .user-dashboard-hero p {
        color: rgba(247,249,255,0.8);
        margin-bottom: 20px;
    }
    .user-dashboard-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit,minmax(180px,1fr));
        gap: 16px;
        margin-top: 28px;
    }
    .user-dashboard-stat-card {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 18px;
        padding: 16px 18px;
    }
    .user-dashboard-stat-card span {
        font-size: 0.8rem;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.7);
    }
    .user-dashboard-stat-card strong {
        display: block;
        font-size: 1.8rem;
        margin-top: 6px;
    }
    .user-dashboard-grid {
        margin-top: 40px;
        display: grid;
        grid-template-columns: minmax(0,1fr);
        gap: 24px;
    }
    @media(min-width: 992px) {
        .user-dashboard-grid {
            grid-template-columns: minmax(0,3fr) minmax(280px,1fr);
        }
    }
    .user-dashboard-card {
        background: #fff;
        border-radius: 24px;
        border: 1px solid rgba(15,23,42,0.06);
        padding: 26px;
        box-shadow: 0 35px 65px -55px rgba(10,13,35,0.9);
    }
    .user-dashboard-card h2 {
        font-size: 1.3rem;
        margin-bottom: 18px;
        color: #0f172a;
    }
    .user-dashboard-announcement {
        display: flex;
        gap: 16px;
        padding: 16px 0;
        border-bottom: 1px solid rgba(15,23,42,0.06);
    }
    .user-dashboard-announcement:last-child {
        border-bottom: none;
    }
    .user-dashboard-announcement img {
        width: 72px;
        height: 72px;
        border-radius: 12px;
        object-fit: cover;
        background: #f1f5f9;
    }
    .user-dashboard-announcement-title {
        font-weight: 600;
        color: #111827;
        margin-bottom: 4px;
    }
    .user-dashboard-announcement-meta {
        font-size: 0.85rem;
        color: #64748b;
    }
    .user-dashboard-section-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit,minmax(220px,1fr));
        gap: 14px;
    }
    .user-dashboard-pill-card {
        border-radius: 20px;
        border: 1px dashed rgba(15,23,42,0.12);
        padding: 18px;
        background: #f8fafc;
    }
    .user-dashboard-pill-card h3 {
        font-size: 1rem;
        margin-bottom: 4px;
        color: #0f172a;
    }
    .user-dashboard-pill-card p {
        font-size: 0.9rem;
        color: #475569;
        margin-bottom: 12px;
    }
    .user-dashboard-pill-card a {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
        font-size: 0.9rem;
        color: #0f75ff;
        text-decoration: none;
    }
    .user-dashboard-sidebar-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid rgba(15,23,42,0.06);
        padding: 20px;
        margin-bottom: 18px;
    }
    .user-dashboard-empty {
        border: 1px dashed rgba(148,163,184,0.7);
        border-radius: 16px;
        padding: 22px;
        text-align: center;
        color: #64748b;
    }
    .user-dashboard-empty a {
        color: #0f75ff;
        font-weight: 600;
        text-decoration: none;
    }
    .user-dashboard-shell {
        display: flex;
        gap: 32px;
        align-items: flex-start;
    }
    .user-dashboard-sidebar {
        width: 260px;
        background: #fff;
        border-radius: 26px;
        border: 1px solid rgba(15,23,42,0.08);
        padding: 24px;
        box-shadow: 0 25px 60px -45px rgba(9,12,30,0.65);
        position: sticky;
        top: 110px;
        height: fit-content;
    }
    .user-dashboard-sidebar h3 {
        margin-bottom: 18px;
        font-size: 1rem;
        color: #0f172a;
        text-transform: uppercase;
        letter-spacing: 0.2em;
    }
    .user-dashboard-sidebar-nav {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .user-dashboard-sidebar-link {
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-decoration: none;
        padding: 12px 14px;
        border-radius: 16px;
        color: #475569;
        font-weight: 500;
        border: 1px solid transparent;
    }
    .user-dashboard-sidebar-link span {
        font-size: 0.82rem;
        color: #94a3b8;
    }
    .user-dashboard-sidebar-link--active {
        background: #0f75ff;
        color: #fff;
        border-color: #0f75ff;
    }
    .user-dashboard-sidebar-link--active span {
        color: rgba(255,255,255,0.8);
    }
    .user-dashboard-main {
        flex: 1;
    }
    @media(max-width: 1024px) {
        .user-dashboard-shell {
            flex-direction: column;
        }
        .user-dashboard-sidebar {
            position: static;
            width: 100%;
        }
    }
</style>

<section class="user-dashboard-hero">
    <div class="user-dashboard-container">
        <h1>Bonjour {{ $user->name }}</h1>
        <p>Suivez vos annonces, vos boutiques et vos restaurants en un coup d'œil.</p>
        <div class="user-dashboard-stats">
            <div class="user-dashboard-stat-card">
                <span>Annonces</span>
                <strong>{{ $stats['total'] }}</strong>
            </div>
            <div class="user-dashboard-stat-card">
                <span>Actives</span>
                <strong>{{ $stats['active'] }}</strong>
            </div>
            <div class="user-dashboard-stat-card">
                <span>En attente</span>
                <strong>{{ $stats['pending'] }}</strong>
            </div>
            <div class="user-dashboard-stat-card">
                <span>En vedette</span>
                <strong>{{ $stats['featured'] }}</strong>
            </div>
        </div>
    </div>
</section>

<section class="user-dashboard-container" style="padding-top:32px;padding-bottom:48px;">
    <div class="user-dashboard-shell">
        <aside class="user-dashboard-sidebar">
            <h3>Tableau</h3>
            <ul class="user-dashboard-sidebar-nav">
                <li>
                    <a href="{{ route('dashboard') }}" class="user-dashboard-sidebar-link user-dashboard-sidebar-link--active">
                        Aperçu
                        <span>{{ $stats['total'] }} annonces</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.announcements') }}" class="user-dashboard-sidebar-link">
                        Mes annonces
                        <span>{{ $stats['active'] }} actives</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.boutiques') }}" class="user-dashboard-sidebar-link">
                        Mes boutiques
                        <span>{{ $boutiques->count() }} listées</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.restaurants') }}" class="user-dashboard-sidebar-link">
                        Mes restaurants
                        <span>{{ $restaurants->count() }} listés</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="user-dashboard-sidebar-link">
                        Paramètres
                        <span>à venir</span>
                    </a>
                </li>
            </ul>
        </aside>

        <div class="user-dashboard-main">
            <div class="user-dashboard-grid">
                <div class="user-dashboard-card">
            <h2>Mes annonces récentes</h2>
            @if($announcements->isEmpty())
                <div class="user-dashboard-empty">
                    Aucune annonce pour l'instant.
                    <a href="{{ route('announcements.create') }}">Publier votre première annonce</a>
                </div>
            @else
                @foreach($announcements as $announcement)
                    <div class="user-dashboard-announcement">
                        <img src="{{ $announcement->image_url }}" alt="{{ $announcement->title }}">
                        <div>
                            <div class="user-dashboard-announcement-title">{{ $announcement->title }}</div>
                            <div class="user-dashboard-announcement-meta">
                                {{ $announcement->category->name ?? 'Sans catégorie' }} •
                                {{ $announcement->status ?? 'brouillon' }} •
                                {{ $announcement->created_at->diffForHumans() }}
                            </div>
                            <div style="margin-top:8px;display:flex;gap:10px;font-size:0.85rem;">
                                <a href="{{ route('announcements.show', $announcement) }}" style="color:#0f75ff;text-decoration:none;font-weight:600;">Voir</a>
                                <a href="{{ route('announcements.edit', $announcement) }}" style="color:#0f172a;text-decoration:none;">Modifier</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            <div style="margin-top:22px;display:flex;gap:12px;flex-wrap:wrap;">
                <a href="{{ route('announcements.create') }}" style="background:#0f172a;color:#fff;padding:12px 18px;border-radius:14px;text-decoration:none;font-weight:600;">Publier une annonce</a>
                <a href="{{ route('announcements.index') }}" style="border:1px solid rgba(15,23,42,0.2);padding:12px 18px;border-radius:14px;text-decoration:none;color:#0f172a;">Voir toutes mes annonces</a>
            </div>
                </div>

                <div style="display:flex;flex-direction:column;gap:18px;">
                    <div class="user-dashboard-sidebar-card">
                <p style="font-size:0.75rem;letter-spacing:0.2em;color:#94a3b8;text-transform:uppercase;">Boutiques</p>
                <h3 style="margin:6px 0 14px;font-size:1.1rem;color:#0f172a;">Mes boutiques</h3>
                @if($boutiques->isEmpty())
                    <div class="user-dashboard-empty" style="margin-bottom:12px;">
                        Aucune boutique enregistrée.
                    </div>
                @else
                    <ul style="list-style:none;padding:0;margin:0 0 12px 0;">
                        @foreach($boutiques as $boutique)
                            <li style="padding:10px 0;border-bottom:1px solid rgba(15,23,42,0.05);font-size:0.95rem;">
                                {{ $boutique->name }}
                                <span style="display:block;font-size:0.8rem;color:#94a3b8;">
                                    {{ $boutique->status }}
                                    • {{ $boutique->articles_count }} article{{ $boutique->articles_count > 1 ? 's' : '' }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
                <a href="{{ route('boutiques.create') }}" style="display:inline-flex;align-items:center;gap:8px;text-decoration:none;color:#0f75ff;font-weight:600;">
                    + Ajouter une boutique
                </a>
            </div>

            <div class="user-dashboard-sidebar-card">
                <p style="font-size:0.75rem;letter-spacing:0.2em;color:#94a3b8;text-transform:uppercase;">Restaurants</p>
                <h3 style="margin:6px 0 14px;font-size:1.1rem;color:#0f172a;">Mes restaurants</h3>
                @if($restaurants->isEmpty())
                    <div class="user-dashboard-empty" style="margin-bottom:12px;">
                        Aucun restaurant enregistré.
                    </div>
                @else
                    <ul style="list-style:none;padding:0;margin:0 0 12px 0;">
                        @foreach($restaurants as $restaurant)
                            <li style="padding:10px 0;border-bottom:1px solid rgba(15,23,42,0.05);font-size:0.95rem;">
                                {{ $restaurant->name }}
                                <span style="display:block;font-size:0.8rem;color:#94a3b8;">
                                    {{ $restaurant->status }}
                                    • {{ $restaurant->menu_items_count }} plat{{ $restaurant->menu_items_count > 1 ? 's' : '' }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
                <a href="{{ route('restaurants.create') }}" style="display:inline-flex;align-items:center;gap:8px;text-decoration:none;color:#0f75ff;font-weight:600;">
                    + Ajouter un restaurant
                </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

