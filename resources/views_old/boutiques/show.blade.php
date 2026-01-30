@extends('layouts.app')

@section('title', $boutique->name . ' - Sanar Market')

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
    .boutique-detail-card {
        background: #fff;
        border-radius: 24px;
        border: 1px solid rgba(15,23,42,0.06);
        padding: 32px;
        box-shadow: 0 35px 65px -55px rgba(10,13,35,0.9);
        margin-bottom: 24px;
    }
    .boutique-cover {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 18px;
        margin-bottom: 24px;
        background: #f1f5f9;
    }
    .boutique-header {
        margin-bottom: 24px;
    }
    .boutique-title {
        font-size: 2rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
    }
    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 16px;
    }
    .status-draft {
        background: #e5e7eb;
        color: #374151;
    }
    .status-active {
        background: #d1fae5;
        color: #065f46;
    }
    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }
    .boutique-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
        padding: 20px;
        background: #f8fafc;
        border-radius: 16px;
    }
    .info-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        font-size: 0.9rem;
    }
    .info-item strong {
        color: #0f172a;
    }
    .boutique-description {
        color: #475569;
        line-height: 1.7;
        margin-bottom: 24px;
        font-size: 1rem;
    }
    .social-links {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 16px;
    }
    .social-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        background: #f1f5f9;
        border-radius: 10px;
        text-decoration: none;
        color: #0f172a;
        font-size: 0.9rem;
        transition: all 0.2s;
    }
    .social-link:hover {
        background: #e2e8f0;
    }
    .btn {
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    .btn-primary {
        background: #0f75ff;
        color: #fff;
    }
    .btn-primary:hover {
        background: #0d66e5;
    }
    .btn-secondary {
        background: transparent;
        color: #0f172a;
        border: 1px solid rgba(15,23,42,0.2);
    }
    .btn-secondary:hover {
        background: #f8fafc;
    }
    .btn-danger {
        background: #ef4444;
        color: #fff;
    }
    .btn-danger:hover {
        background: #dc2626;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 16px;
        margin-top: 24px;
    }
    .stat-card {
        background: #f8fafc;
        padding: 20px;
        border-radius: 16px;
        text-align: center;
    }
    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
    }
    .stat-label {
        font-size: 0.85rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
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
        <h1>{{ $boutique->name }}</h1>
        <p>Détails de votre boutique</p>
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
                    <a href="{{ route('dashboard.boutiques') }}" class="user-dashboard-sidebar-link">
                        Mes boutiques
                        <span>{{ $stats['total_boutiques'] }} listées</span>
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
            <div class="boutique-detail-card">
                @if($boutique->cover_image)
                    <img src="{{ asset('storage/' . $boutique->cover_image) }}" alt="{{ $boutique->name }}" class="boutique-cover">
                @else
                    <div class="boutique-cover" style="display:flex;align-items:center;justify-content:center;color:#94a3b8;">
                        <span>Aucune image</span>
                    </div>
                @endif

                <div class="boutique-header">
                    <h2 class="boutique-title">{{ $boutique->name }}</h2>
                    <span class="status-badge status-{{ $boutique->status }}">
                        {{ $boutique->status }}
                    </span>
                </div>

                <div class="boutique-info">
                    @if($boutique->address)
                        <div class="info-item">
                            <span>📍</span>
                            <div>
                                <strong>Adresse:</strong> {{ $boutique->address }}
                            </div>
                        </div>
                    @endif
                    @if($boutique->phone)
                        <div class="info-item">
                            <span>📞</span>
                            <div>
                                <strong>Téléphone:</strong> {{ $boutique->phone }}
                            </div>
                        </div>
                    @endif
                </div>

                @if($boutique->description)
                    <div class="boutique-description">
                        {{ $boutique->description }}
                    </div>
                @endif

                @if($boutique->social_links && count(array_filter($boutique->social_links)))
                    <div>
                        <h3 style="font-size:1.1rem;font-weight:600;color:#0f172a;margin-bottom:12px;">Liens sociaux</h3>
                        <div class="social-links">
                            @if(isset($boutique->social_links['facebook']))
                                <a href="{{ $boutique->social_links['facebook'] }}" target="_blank" class="social-link">
                                    <span>📘</span> Facebook
                                </a>
                            @endif
                            @if(isset($boutique->social_links['instagram']))
                                <a href="{{ $boutique->social_links['instagram'] }}" target="_blank" class="social-link">
                                    <span>📷</span> Instagram
                                </a>
                            @endif
                            @if(isset($boutique->social_links['twitter']))
                                <a href="{{ $boutique->social_links['twitter'] }}" target="_blank" class="social-link">
                                    <span>🐦</span> Twitter
                                </a>
                            @endif
                            @if(isset($boutique->social_links['website']))
                                <a href="{{ $boutique->social_links['website'] }}" target="_blank" class="social-link">
                                    <span>🌐</span> Site web
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value">{{ $boutique->articles_count }}</div>
                        <div class="stat-label">Articles</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">{{ $boutique->categories_count }}</div>
                        <div class="stat-label">Catégories</div>
                    </div>
                </div>

                <div style="display:flex;gap:12px;margin-top:32px;padding-top:24px;border-top:1px solid rgba(15,23,42,0.1);">
                    <a href="{{ route('boutiques.edit', $boutique) }}" class="btn btn-primary" style="flex:1;text-align:center;">
                        Modifier
                    </a>
                    <a href="{{ route('dashboard.boutiques') }}" class="btn btn-secondary" style="flex:1;text-align:center;">
                        Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

