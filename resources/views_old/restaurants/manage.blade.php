@extends('layouts.app')

@section('title', 'Gérer ' . $restaurant->name . ' - Sanar Market')

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
    .manage-card {
        background: #fff;
        border-radius: 24px;
        border: 1px solid rgba(15,23,42,0.06);
        padding: 32px;
        box-shadow: 0 35px 65px -55px rgba(10,13,35,0.9);
        margin-bottom: 24px;
    }
    .tabs {
        display: flex;
        gap: 8px;
        border-bottom: 2px solid rgba(15,23,42,0.1);
        margin-bottom: 24px;
    }
    .tab {
        padding: 12px 24px;
        background: transparent;
        border: none;
        border-bottom: 3px solid transparent;
        font-size: 0.95rem;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s;
    }
    .tab:hover {
        color: #0f172a;
    }
    .tab.active {
        color: #0f75ff;
        border-bottom-color: #0f75ff;
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
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
    .btn {
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
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
    .btn-sm {
        padding: 6px 12px;
        font-size: 0.85rem;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    .table th,
    .table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid rgba(15,23,42,0.1);
    }
    .table th {
        font-weight: 600;
        color: #0f172a;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .table td {
        color: #475569;
    }
    .table tr:hover {
        background: #f8fafc;
    }
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #64748b;
    }
    .empty-state p {
        margin-bottom: 16px;
    }
    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
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
    .action-buttons {
        display: flex;
        gap: 8px;
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
        <h1>Gérer {{ $restaurant->name }}</h1>
        <p>Gérez le menu, les horaires et les paramètres de votre restaurant.</p>
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
            <div class="manage-card">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
                    <div>
                        <h2 style="font-size:1.5rem;font-weight:700;color:#0f172a;margin-bottom:4px;">{{ $restaurant->name }}</h2>
                        <span class="status-badge status-{{ $restaurant->status }}">{{ $restaurant->status }}</span>
                    </div>
                    <div style="display:flex;gap:12px;">
                        <a href="{{ route('restaurants.show', $restaurant) }}" class="btn btn-secondary">Voir</a>
                        <a href="{{ route('restaurants.edit', $restaurant) }}" class="btn btn-secondary">Modifier</a>
                    </div>
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value">{{ $restaurant->menu_items_count }}</div>
                        <div class="stat-label">Plats au menu</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">{{ $restaurant->schedules_count }}</div>
                        <div class="stat-label">Horaires</div>
                    </div>
                </div>

                <div class="tabs">
                    <button class="tab active" onclick="switchTab('overview')">Vue d'ensemble</button>
                    <button class="tab" onclick="switchTab('menu')">Menu ({{ $restaurant->menuItems->count() }})</button>
                    <button class="tab" onclick="switchTab('schedules')">Horaires ({{ $restaurant->schedules->count() }})</button>
                </div>

                <!-- Vue d'ensemble -->
                <div id="tab-overview" class="tab-content active">
                    <h3 style="font-size:1.2rem;font-weight:600;color:#0f172a;margin-bottom:16px;">Informations du restaurant</h3>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px;">
                        <div>
                            <p style="font-size:0.85rem;color:#64748b;margin-bottom:4px;">Nom</p>
                            <p style="font-weight:600;color:#0f172a;">{{ $restaurant->name }}</p>
                        </div>
                        <div>
                            <p style="font-size:0.85rem;color:#64748b;margin-bottom:4px;">Statut</p>
                            <span class="status-badge status-{{ $restaurant->status }}">{{ $restaurant->status }}</span>
                        </div>
                        @if($restaurant->address)
                        <div>
                            <p style="font-size:0.85rem;color:#64748b;margin-bottom:4px;">Adresse</p>
                            <p style="font-weight:500;color:#0f172a;">{{ $restaurant->address }}</p>
                        </div>
                        @endif
                        @if($restaurant->phone)
                        <div>
                            <p style="font-size:0.85rem;color:#64748b;margin-bottom:4px;">Téléphone</p>
                            <p style="font-weight:500;color:#0f172a;">{{ $restaurant->phone }}</p>
                        </div>
                        @endif
                        @if($restaurant->metadata && isset($restaurant->metadata['cuisine_type']))
                        <div>
                            <p style="font-size:0.85rem;color:#64748b;margin-bottom:4px;">Type de cuisine</p>
                            <p style="font-weight:500;color:#0f172a;">{{ $restaurant->metadata['cuisine_type'] }}</p>
                        </div>
                        @endif
                        @if($restaurant->metadata && isset($restaurant->metadata['price_range']))
                        <div>
                            <p style="font-size:0.85rem;color:#64748b;margin-bottom:4px;">Fourchette de prix</p>
                            <p style="font-weight:500;color:#0f172a;">{{ $restaurant->metadata['price_range'] }}</p>
                        </div>
                        @endif
                    </div>
                    @if($restaurant->description)
                    <div>
                        <p style="font-size:0.85rem;color:#64748b;margin-bottom:4px;">Description</p>
                        <p style="color:#475569;line-height:1.6;">{{ $restaurant->description }}</p>
                    </div>
                    @endif
                </div>

                <!-- Menu -->
                <div id="tab-menu" class="tab-content">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                        <h3 style="font-size:1.2rem;font-weight:600;color:#0f172a;">Menu</h3>
                        <a href="{{ route('restaurants.menu-items.create', $restaurant) }}" class="btn btn-primary btn-sm">+ Ajouter un plat</a>
                    </div>

                    @if($restaurant->menuItems->isEmpty())
                        <div class="empty-state">
                            <p>Aucun plat ajouté au menu pour l'instant.</p>
                            <a href="{{ route('restaurants.menu-items.create', $restaurant) }}" class="btn btn-primary">Ajouter votre premier plat</a>
                        </div>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Plat</th>
                                    <th>Prix (FCFA)</th>
                                    <th>Disponibilité</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($restaurant->menuItems as $item)
                                    <tr>
                                        <td><strong>{{ $item->title }}</strong></td>
                                        <td>{{ number_format($item->price, 0, ',', ' ') }} FCFA</td>
                                        <td>
                                            @if($item->is_available)
                                                <span style="color:#065f46;font-weight:600;">✓ Disponible</span>
                                            @else
                                                <span style="color:#dc2626;font-weight:600;">✗ Indisponible</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn btn-secondary btn-sm" onclick="alert('Fonctionnalité à venir : Modifier')">Modifier</button>
                                                <button class="btn btn-danger btn-sm" onclick="alert('Fonctionnalité à venir : Supprimer')">Supprimer</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                <!-- Horaires -->
                <div id="tab-schedules" class="tab-content">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                        <h3 style="font-size:1.2rem;font-weight:600;color:#0f172a;">Horaires d'ouverture</h3>
                        <a href="{{ route('restaurants.schedules.create', $restaurant) }}" class="btn btn-primary btn-sm">+ Ajouter un horaire</a>
                    </div>

                    @if($restaurant->schedules->isEmpty())
                        <div class="empty-state">
                            <p>Aucun horaire configuré pour l'instant.</p>
                            <a href="{{ route('restaurants.schedules.create', $restaurant) }}" class="btn btn-primary">Configurer les horaires</a>
                        </div>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Jour</th>
                                    <th>Heure d'ouverture</th>
                                    <th>Heure de fermeture</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
                                @endphp
                                @foreach($restaurant->schedules as $schedule)
                                    <tr>
                                        <td><strong>{{ $days[$schedule->day_of_week] ?? 'Jour ' . $schedule->day_of_week }}</strong></td>
                                        <td>{{ $schedule->opens_at ?? '-' }}</td>
                                        <td>{{ $schedule->closes_at ?? '-' }}</td>
                                        <td>
                                            @if($schedule->is_closed)
                                                <span style="color:#dc2626;font-weight:600;">Fermé</span>
                                            @else
                                                <span style="color:#065f46;font-weight:600;">Ouvert</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn btn-secondary btn-sm" onclick="alert('Fonctionnalité à venir : Modifier')">Modifier</button>
                                                <button class="btn btn-danger btn-sm" onclick="alert('Fonctionnalité à venir : Supprimer')">Supprimer</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function switchTab(tabName) {
        // Masquer tous les contenus d'onglets
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('active');
        });

        // Désactiver tous les onglets
        document.querySelectorAll('.tab').forEach(tab => {
            tab.classList.remove('active');
        });

        // Afficher le contenu sélectionné
        document.getElementById('tab-' + tabName).classList.add('active');

        // Activer l'onglet sélectionné
        event.target.classList.add('active');
    }
</script>
@endsection

