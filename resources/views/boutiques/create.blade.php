@extends('layouts.app')

@section('title', 'Créer une boutique - Sanar Market')

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
        <h1>Créer une boutique</h1>
        <p>Remplissez les informations ci-dessous pour créer votre boutique.</p>
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
                <form method="POST" action="{{ route('boutiques.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="form-label">
                            Nom de la boutique <span class="required">*</span>
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               required
                               value="{{ old('name') }}"
                               class="form-input @error('name') border-red-500 @enderror"
                               placeholder="ex: Ma Boutique Fashion">
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">
                            Description
                        </label>
                        <textarea id="description"
                                  name="description"
                                  rows="5"
                                  class="form-input form-textarea @error('description') border-red-500 @enderror"
                                  placeholder="Décrivez votre boutique, vos produits, vos services...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                        <p class="form-help">Décrivez votre boutique en détail pour attirer plus de clients.</p>
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">
                            Adresse
                        </label>
                        <input type="text"
                               id="address"
                               name="address"
                               value="{{ old('address') }}"
                               class="form-input @error('address') border-red-500 @enderror"
                               placeholder="ex: 123 Rue de la Paix, Dakar">
                        @error('address')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">
                            Téléphone
                        </label>
                        <input type="tel"
                               id="phone"
                               name="phone"
                               value="{{ old('phone') }}"
                               class="form-input @error('phone') border-red-500 @enderror"
                               placeholder="+221 77 123 45 67">
                        @error('phone')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="cover_image" class="form-label">
                            Image de couverture
                        </label>
                        <input type="file"
                               id="cover_image"
                               name="cover_image"
                               accept="image/jpeg,image/png,image/jpg,image/gif"
                               class="form-input @error('cover_image') border-red-500 @enderror">
                        @error('cover_image')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                        <p class="form-help">Image principale de votre boutique (JPEG, PNG, JPG, GIF - Max 2MB)</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Liens sociaux</label>
                        <div style="display:grid;grid-template-columns:1fr;gap:12px;">
                            <div>
                                <label for="social_links_facebook" style="font-size:0.85rem;color:#64748b;margin-bottom:4px;display:block;">Facebook</label>
                                <input type="url"
                                       id="social_links_facebook"
                                       name="social_links[facebook]"
                                       value="{{ old('social_links.facebook') }}"
                                       class="form-input"
                                       placeholder="https://facebook.com/votre-page">
                            </div>
                            <div>
                                <label for="social_links_instagram" style="font-size:0.85rem;color:#64748b;margin-bottom:4px;display:block;">Instagram</label>
                                <input type="url"
                                       id="social_links_instagram"
                                       name="social_links[instagram]"
                                       value="{{ old('social_links.instagram') }}"
                                       class="form-input"
                                       placeholder="https://instagram.com/votre-compte">
                            </div>
                            <div>
                                <label for="social_links_twitter" style="font-size:0.85rem;color:#64748b;margin-bottom:4px;display:block;">Twitter</label>
                                <input type="url"
                                       id="social_links_twitter"
                                       name="social_links[twitter]"
                                       value="{{ old('social_links.twitter') }}"
                                       class="form-input"
                                       placeholder="https://twitter.com/votre-compte">
                            </div>
                            <div>
                                <label for="social_links_website" style="font-size:0.85rem;color:#64748b;margin-bottom:4px;display:block;">Site web</label>
                                <input type="url"
                                       id="social_links_website"
                                       name="social_links[website]"
                                       value="{{ old('social_links.website') }}"
                                       class="form-input"
                                       placeholder="https://votre-site.com">
                            </div>
                        </div>
                    </div>

                    <div style="display:flex;gap:12px;margin-top:32px;padding-top:24px;border-top:1px solid rgba(15,23,42,0.1);">
                        <a href="{{ route('dashboard.boutiques') }}" class="btn btn-secondary" style="flex:1;text-align:center;">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary" style="flex:1;">
                            Créer la boutique
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

