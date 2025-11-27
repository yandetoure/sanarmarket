@extends('layouts.app')

@section('title', 'Configurer les horaires - ' . $restaurant->name . ' - Sanar Market')

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
    .form-card {
        background: #fff;
        border-radius: 24px;
        border: 1px solid rgba(15,23,42,0.06);
        padding: 32px;
        box-shadow: 0 35px 65px -55px rgba(10,13,35,0.9);
    }
    .form-group {
        margin-bottom: 24px;
    }
    .form-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 8px;
    }
    .form-label .required {
        color: #ef4444;
    }
    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid rgba(15,23,42,0.2);
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.2s;
    }
    .form-input:focus {
        outline: none;
        border-color: #0f75ff;
        box-shadow: 0 0 0 3px rgba(15,117,255,0.1);
    }
    .form-select {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid rgba(15,23,42,0.2);
        border-radius: 12px;
        font-size: 0.95rem;
        background: #fff;
        transition: all 0.2s;
    }
    .form-select:focus {
        outline: none;
        border-color: #0f75ff;
        box-shadow: 0 0 0 3px rgba(15,117,255,0.1);
    }
    .form-error {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 6px;
    }
    .form-help {
        color: #64748b;
        font-size: 0.85rem;
        margin-top: 6px;
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
        background: #0f172a;
        color: #fff;
    }
    .btn-primary:hover {
        background: #1e293b;
    }
    .btn-secondary {
        background: transparent;
        color: #0f172a;
        border: 1px solid rgba(15,23,42,0.2);
    }
    .btn-secondary:hover {
        background: #f8fafc;
    }
    .restaurant-info {
        background: #f8fafc;
        padding: 16px;
        border-radius: 12px;
        margin-bottom: 24px;
    }
    .restaurant-info p {
        margin: 0;
        font-size: 0.9rem;
        color: #64748b;
    }
    .restaurant-info strong {
        color: #0f172a;
    }
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .closed-options {
        display: none;
        margin-top: 12px;
        padding: 16px;
        background: #fef3c7;
        border-radius: 12px;
        color: #92400e;
        font-size: 0.9rem;
    }
    .closed-options.active {
        display: block;
    }
    @media(max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
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
        <h1>Configurer les horaires</h1>
        <p>Ajoutez un horaire d'ouverture pour votre restaurant.</p>
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
            <div class="form-card">
                <div class="restaurant-info">
                    <p><strong>Restaurant:</strong> {{ $restaurant->name }}</p>
                </div>

                <form method="POST" action="{{ route('restaurants.schedules.store', $restaurant) }}">
                    @csrf

                    <div class="form-group">
                        <label for="day_of_week" class="form-label">
                            Jour de la semaine <span class="required">*</span>
                        </label>
                        <select id="day_of_week"
                                name="day_of_week"
                                required
                                class="form-select @error('day_of_week') border-red-500 @enderror">
                            <option value="">Sélectionner un jour</option>
                            <option value="0" {{ old('day_of_week') == '0' ? 'selected' : '' }}>Lundi</option>
                            <option value="1" {{ old('day_of_week') == '1' ? 'selected' : '' }}>Mardi</option>
                            <option value="2" {{ old('day_of_week') == '2' ? 'selected' : '' }}>Mercredi</option>
                            <option value="3" {{ old('day_of_week') == '3' ? 'selected' : '' }}>Jeudi</option>
                            <option value="4" {{ old('day_of_week') == '4' ? 'selected' : '' }}>Vendredi</option>
                            <option value="5" {{ old('day_of_week') == '5' ? 'selected' : '' }}>Samedi</option>
                            <option value="6" {{ old('day_of_week') == '6' ? 'selected' : '' }}>Dimanche</option>
                        </select>
                        @error('day_of_week')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="is_closed" class="form-label">
                            Statut
                        </label>
                        <select id="is_closed"
                                name="is_closed"
                                class="form-select @error('is_closed') border-red-500 @enderror"
                                onchange="toggleClosedOptions()">
                            <option value="0" {{ old('is_closed', '0') == '0' ? 'selected' : '' }}>Ouvert</option>
                            <option value="1" {{ old('is_closed') == '1' ? 'selected' : '' }}>Fermé</option>
                        </select>
                        @error('is_closed')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="hours-options" class="{{ old('is_closed') == '1' ? '' : '' }}">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="opens_at" class="form-label">
                                    Heure d'ouverture
                                </label>
                                <input type="time"
                                       id="opens_at"
                                       name="opens_at"
                                       value="{{ old('opens_at') }}"
                                       class="form-input @error('opens_at') border-red-500 @enderror">
                                @error('opens_at')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="closes_at" class="form-label">
                                    Heure de fermeture
                                </label>
                                <input type="time"
                                       id="closes_at"
                                       name="closes_at"
                                       value="{{ old('closes_at') }}"
                                       class="form-input @error('closes_at') border-red-500 @enderror">
                                @error('closes_at')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div id="closed-message" class="closed-options {{ old('is_closed') == '1' ? 'active' : '' }}">
                        <p>⚠️ Le restaurant sera marqué comme fermé ce jour. Les heures d'ouverture ne sont pas nécessaires.</p>
                    </div>

                    <div style="display:flex;gap:12px;margin-top:32px;padding-top:24px;border-top:1px solid rgba(15,23,42,0.1);">
                        <a href="{{ route('restaurants.manage', $restaurant) }}" class="btn btn-secondary" style="flex:1;text-align:center;">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary" style="flex:1;">
                            Enregistrer l'horaire
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    function toggleClosedOptions() {
        const isClosed = document.getElementById('is_closed').value === '1';
        const hoursOptions = document.getElementById('hours-options');
        const closedMessage = document.getElementById('closed-message');
        
        if (isClosed) {
            hoursOptions.style.display = 'none';
            closedMessage.classList.add('active');
            document.getElementById('opens_at').removeAttribute('required');
            document.getElementById('closes_at').removeAttribute('required');
        } else {
            hoursOptions.style.display = 'block';
            closedMessage.classList.remove('active');
            document.getElementById('opens_at').setAttribute('required', 'required');
            document.getElementById('closes_at').setAttribute('required', 'required');
        }
    }
    
    // Initialiser l'état au chargement
    document.addEventListener('DOMContentLoaded', function() {
        toggleClosedOptions();
    });
</script>
@endsection

