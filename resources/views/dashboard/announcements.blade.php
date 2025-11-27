@extends('layouts.app')

@section('title', 'Mes annonces - Sanar Market')

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
        width: 100px;
        height: 100px;
        border-radius: 12px;
        object-fit: cover;
        background: #f1f5f9;
    }
    .user-dashboard-announcement-title {
        font-weight: 600;
        color: #111827;
        margin-bottom: 4px;
        font-size: 1.1rem;
    }
    .user-dashboard-announcement-meta {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 8px;
    }
    .user-dashboard-announcement-actions {
        display: flex;
        gap: 10px;
        margin-top: 8px;
    }
    .user-dashboard-announcement-actions a {
        padding: 6px 14px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.85rem;
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
    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    .status-active {
        background: #d1fae5;
        color: #065f46;
    }
    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }
    .status-draft {
        background: #e5e7eb;
        color: #374151;
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
        <h1>Mes annonces</h1>
        <p>Gérez toutes vos annonces en un seul endroit.</p>
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
                    <a href="{{ route('dashboard.announcements') }}" class="user-dashboard-sidebar-link user-dashboard-sidebar-link--active">
                        Mes annonces
                        <span>{{ $stats['active'] }} actives</span>
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
            <div class="user-dashboard-card">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
                    <h2>Toutes mes annonces</h2>
                    <a href="{{ route('announcements.create') }}" style="background:#0f172a;color:#fff;padding:12px 18px;border-radius:14px;text-decoration:none;font-weight:600;">+ Publier une annonce</a>
                </div>

                @if($announcements->isEmpty())
                    <div class="user-dashboard-empty">
                        <p style="margin-bottom:12px;">Aucune annonce pour l'instant.</p>
                        <a href="{{ route('announcements.create') }}">Publier votre première annonce</a>
                    </div>
                @else
                    <div>
                        @foreach($announcements as $announcement)
                            <div class="user-dashboard-announcement">
                                <img src="{{ $announcement->image_url }}" alt="{{ $announcement->title }}">
                                <div style="flex:1;">
                                    <div class="user-dashboard-announcement-title">{{ $announcement->title }}</div>
                                    <div class="user-dashboard-announcement-meta">
                                        <span class="status-badge status-{{ $announcement->status ?? 'draft' }}">
                                            {{ $announcement->status ?? 'brouillon' }}
                                        </span>
                                        • {{ $announcement->category->name ?? 'Sans catégorie' }}
                                        • {{ $announcement->created_at->diffForHumans() }}
                                        @if($announcement->featured)
                                            • <span style="color:#f59e0b;">⭐ En vedette</span>
                                        @endif
                                    </div>
                                    <p style="font-size:0.9rem;color:#64748b;margin:8px 0;line-height:1.5;">
                                        {{ Str::limit($announcement->description, 120) }}
                                    </p>
                                    <div class="user-dashboard-announcement-actions">
                                        <a href="{{ route('announcements.show', $announcement) }}" class="btn-primary">Voir</a>
                                        <a href="{{ route('announcements.edit', $announcement) }}" class="btn-secondary">Modifier</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div style="margin-top:24px;">
                        {{ $announcements->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

