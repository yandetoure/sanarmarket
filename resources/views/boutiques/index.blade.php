@extends('layouts.app')

@section('title', 'Mes boutiques - Sanar Market')

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
    .user-dashboard-card {
        background: #fff;
        border-radius: 24px;
        border: 1px solid rgba(15,23,42,0.06);
        padding: 26px;
        box-shadow: 0 35px 65px -55px rgba(10,13,35,0.9);
        margin-bottom: 24px;
    }
    .user-dashboard-card h2 {
        font-size: 1.3rem;
        margin-bottom: 18px;
        color: #0f172a;
    }
    .boutique-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }
    .boutique-card {
        background: #f8fafc;
        border: 1px solid rgba(15,23,42,0.08);
        border-radius: 18px;
        padding: 20px;
        transition: all 0.2s;
    }
    .boutique-card:hover {
        border-color: #0f75ff;
        box-shadow: 0 4px 12px rgba(15,117,255,0.1);
    }
    .boutique-card h3 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 8px;
    }
    .boutique-card-meta {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 12px;
    }
    .boutique-card-actions {
        display: flex;
        gap: 10px;
        margin-top: 16px;
    }
    .boutique-card-actions a {
        padding: 8px 16px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
    }
    .btn-primary {
        background: #0f75ff;
        color: #fff;
    }
    .btn-secondary {
        background: transparent;
        color: #0f172a;
        border: 1px solid rgba(15,23,42,0.2);
    }
    .user-dashboard-empty {
        border: 1px dashed rgba(148,163,184,0.7);
        border-radius: 16px;
        padding: 40px 22px;
        text-align: center;
        color: #64748b;
    }
    .user-dashboard-empty a {
        color: #0f75ff;
        font-weight: 600;
        text-decoration: none;
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
        <h1>Mes boutiques</h1>
        <p>Gérez toutes vos boutiques en un seul endroit.</p>
    </div>
</section>

<section class="user-dashboard-container" style="padding-top:32px;padding-bottom:48px;">
    <div class="user-dashboard-shell">
        <aside class="user-dashboard-sidebar">
            <h3>Navigation</h3>
            <ul class="user-dashboard-sidebar-nav">
                <li>
                    <a href="{{ route('dashboard') }}" class="user-dashboard-sidebar-link">
                        Aperçu
                        <span>Tableau de bord</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.announcements') }}" class="user-dashboard-sidebar-link">
                        Mes annonces
                        <span>{{ $stats['active_announcements'] }} actives</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.boutiques') }}" class="user-dashboard-sidebar-link user-dashboard-sidebar-link--active">
                        Mes boutiques
                        <span>{{ $boutiques->total() }} listées</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.restaurants') }}" class="user-dashboard-sidebar-link">
                        Mes restaurants
                        <span>{{ $stats['total_restaurants'] }} listés</span>
                    </a>
                </li>
            </ul>
        </aside>

        <div class="user-dashboard-main">
            <div class="user-dashboard-card">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
                    <h2>Toutes mes boutiques</h2>
                    <a href="{{ route('boutiques.create') }}" style="background:#0f172a;color:#fff;padding:12px 18px;border-radius:14px;text-decoration:none;font-weight:600;">+ Ajouter une boutique</a>
                </div>

                @if($boutiques->isEmpty())
                    <div class="user-dashboard-empty">
                        <p style="margin-bottom:12px;">Aucune boutique enregistrée pour l'instant.</p>
                        <a href="{{ route('boutiques.create') }}">Créer votre première boutique</a>
                    </div>
                @else
                    <div class="boutique-grid">
                        @foreach($boutiques as $boutique)
                            <div class="boutique-card">
                                <h3>{{ $boutique->name }}</h3>
                                <div class="boutique-card-meta">
                                    <div>Statut: <strong>{{ $boutique->status }}</strong></div>
                                    <div>{{ $boutique->articles_count }} article{{ $boutique->articles_count > 1 ? 's' : '' }} • {{ $boutique->categories_count }} catégorie{{ $boutique->categories_count > 1 ? 's' : '' }}</div>
                                    @if($boutique->address)
                                        <div style="margin-top:4px;">📍 {{ $boutique->address }}</div>
                                    @endif
                                </div>
                                <div class="boutique-card-actions">
                                    <a href="{{ route('boutiques.manage', $boutique) }}" class="btn-primary">Gérer</a>
                                    <a href="{{ route('boutiques.show', $boutique) }}" class="btn-secondary">Voir</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div style="margin-top:24px;">
                        {{ $boutiques->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

