@extends('layouts.app')

@section('title', 'Créer un article - ' . $boutique->name . ' - Sanar Market')

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
    .boutique-info {
        background: #f8fafc;
        padding: 16px;
        border-radius: 12px;
        margin-bottom: 24px;
    }
    .boutique-info p {
        margin: 0;
        font-size: 0.9rem;
        color: #64748b;
    }
    .boutique-info strong {
        color: #0f172a;
    }
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
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
        <h1>Créer un article</h1>
        <p>Ajoutez un nouvel article à votre boutique.</p>
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
                <div class="boutique-info">
                    <p><strong>Boutique:</strong> {{ $boutique->name }}</p>
                </div>

                <form method="POST" action="{{ route('boutiques.articles.store', $boutique) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="form-label">
                            Nom de l'article <span class="required">*</span>
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               required
                               value="{{ old('name') }}"
                               class="form-input @error('name') border-red-500 @enderror"
                               placeholder="ex: T-shirt en coton, Livre de mathématiques">
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
                                  placeholder="Décrivez votre article en détail...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                        <p class="form-help">Décrivez votre article pour aider les clients à mieux le comprendre.</p>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="boutique_category_id" class="form-label">
                                Catégorie
                            </label>
                            <select id="boutique_category_id"
                                    name="boutique_category_id"
                                    class="form-select @error('boutique_category_id') border-red-500 @enderror">
                                <option value="">Sans catégorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('boutique_category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('boutique_category_id')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                            @if($categories->isEmpty())
                                <p class="form-help">Aucune catégorie disponible. <a href="{{ route('boutiques.categories.create', $boutique) }}" style="color:#0f75ff;">Créer une catégorie</a></p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="status" class="form-label">
                                Statut
                            </label>
                            <select id="status"
                                    name="status"
                                    class="form-select @error('status') border-red-500 @enderror">
                                <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Brouillon</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Actif</option>
                            </select>
                            @error('status')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
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
                                   placeholder="ex: 15000">
                            @error('price')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stock" class="form-label">
                                Stock <span class="required">*</span>
                            </label>
                            <input type="number"
                                   id="stock"
                                   name="stock"
                                   min="0"
                                   required
                                   value="{{ old('stock', 0) }}"
                                   class="form-input @error('stock') border-red-500 @enderror"
                                   placeholder="ex: 10">
                            @error('stock')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="image" class="form-label">
                            Image de l'article
                        </label>
                        <input type="file"
                               id="image"
                               name="image"
                               accept="image/jpeg,image/png,image/jpg,image/gif"
                               class="form-input @error('image') border-red-500 @enderror">
                        @error('image')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                        <p class="form-help">Image de l'article (JPEG, PNG, JPG, GIF - Max 2MB)</p>
                    </div>

                    <div style="display:flex;gap:12px;margin-top:32px;padding-top:24px;border-top:1px solid rgba(15,23,42,0.1);">
                        <a href="{{ route('boutiques.manage', $boutique) }}" class="btn btn-secondary" style="flex:1;text-align:center;">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary" style="flex:1;">
                            Créer l'article
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

