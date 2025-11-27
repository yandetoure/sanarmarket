@extends('layouts.app')

@section('title', 'Ajouter un plat - ' . $restaurant->name . ' - Sanar Market')

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
    .form-textarea {
        min-height: 120px;
        resize: vertical;
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
    .availability-options {
        display: none;
        margin-top: 12px;
        padding: 16px;
        background: #f8fafc;
        border-radius: 12px;
    }
    .availability-options.active {
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
        <h1>Ajouter un plat au menu</h1>
        <p>Ajoutez un nouveau plat à votre menu.</p>
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

                <form method="POST" action="{{ route('restaurants.menu-items.store', $restaurant) }}">
                    @csrf

                    <div class="form-group">
                        <label for="title" class="form-label">
                            Nom du plat <span class="required">*</span>
                        </label>
                        <input type="text"
                               id="title"
                               name="title"
                               required
                               value="{{ old('title') }}"
                               class="form-input @error('title') border-red-500 @enderror"
                               placeholder="ex: Thieboudienne, Pizza Margherita">
                        @error('title')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">
                            Description
                        </label>
                        <textarea id="description"
                                  name="description"
                                  rows="4"
                                  class="form-input form-textarea @error('description') border-red-500 @enderror"
                                  placeholder="Décrivez votre plat...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="price" class="form-label">
                                Prix (FCFA) <span class="required">*</span>
                            </label>
                            <input type="number"
                                   id="price"
                                   name="price"
                                   step="0.01"
                                   min="0"
                                   required
                                   value="{{ old('price') }}"
                                   class="form-input @error('price') border-red-500 @enderror"
                                   placeholder="ex: 5000">
                            @error('price')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="is_available" class="form-label">
                                Disponibilité
                            </label>
                            <select id="is_available"
                                    name="is_available"
                                    class="form-select @error('is_available') border-red-500 @enderror">
                                <option value="1" {{ old('is_available', '1') == '1' ? 'selected' : '' }}>Disponible</option>
                                <option value="0" {{ old('is_available') == '0' ? 'selected' : '' }}>Indisponible</option>
                            </select>
                            @error('is_available')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="availability_type" class="form-label">
                            Type de disponibilité
                        </label>
                        <select id="availability_type"
                                name="availability_type"
                                class="form-select @error('availability_type') border-red-500 @enderror"
                                onchange="toggleAvailabilityOptions()">
                            <option value="daily" {{ old('availability_type', 'daily') == 'daily' ? 'selected' : '' }}>Tous les jours</option>
                            <option value="weekly" {{ old('availability_type') == 'weekly' ? 'selected' : '' }}>Jour spécifique</option>
                            <option value="time_range" {{ old('availability_type') == 'time_range' ? 'selected' : '' }}>Plage horaire</option>
                        </select>
                        @error('availability_type')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="weekly-options" class="availability-options {{ old('availability_type') == 'weekly' ? 'active' : '' }}">
                        <div class="form-group">
                            <label for="day_of_week" class="form-label">Jour de la semaine</label>
                            <select id="day_of_week" name="day_of_week" class="form-select">
                                <option value="0" {{ old('day_of_week') == '0' ? 'selected' : '' }}>Lundi</option>
                                <option value="1" {{ old('day_of_week') == '1' ? 'selected' : '' }}>Mardi</option>
                                <option value="2" {{ old('day_of_week') == '2' ? 'selected' : '' }}>Mercredi</option>
                                <option value="3" {{ old('day_of_week') == '3' ? 'selected' : '' }}>Jeudi</option>
                                <option value="4" {{ old('day_of_week') == '4' ? 'selected' : '' }}>Vendredi</option>
                                <option value="5" {{ old('day_of_week') == '5' ? 'selected' : '' }}>Samedi</option>
                                <option value="6" {{ old('day_of_week') == '6' ? 'selected' : '' }}>Dimanche</option>
                            </select>
                        </div>
                    </div>

                    <div id="time-range-options" class="availability-options {{ old('availability_type') == 'time_range' ? 'active' : '' }}">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="starts_at" class="form-label">Heure de début</label>
                                <input type="time"
                                       id="starts_at"
                                       name="starts_at"
                                       value="{{ old('starts_at') }}"
                                       class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="ends_at" class="form-label">Heure de fin</label>
                                <input type="time"
                                       id="ends_at"
                                       name="ends_at"
                                       value="{{ old('ends_at') }}"
                                       class="form-input">
                            </div>
                        </div>
                    </div>

                    <div style="display:flex;gap:12px;margin-top:32px;padding-top:24px;border-top:1px solid rgba(15,23,42,0.1);">
                        <a href="{{ route('restaurants.manage', $restaurant) }}" class="btn btn-secondary" style="flex:1;text-align:center;">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary" style="flex:1;">
                            Ajouter au menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    function toggleAvailabilityOptions() {
        const type = document.getElementById('availability_type').value;
        document.getElementById('weekly-options').classList.remove('active');
        document.getElementById('time-range-options').classList.remove('active');
        
        if (type === 'weekly') {
            document.getElementById('weekly-options').classList.add('active');
        } else if (type === 'time_range') {
            document.getElementById('time-range-options').classList.add('active');
        }
    }
</script>
@endsection

