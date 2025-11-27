@extends('layouts.app')

@section('title', 'Connexion - Sanar Market')

@section('content')
<style>
    .auth-wrapper {
        min-height: calc(100vh - 120px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 16px;
        background: #f6f7fb;
    }
    .auth-card {
        width: 100%;
        max-width: 420px;
        background: #fff;
        border-radius: 24px;
        padding: 40px 36px;
        box-shadow: 0 45px 80px -50px rgba(14,19,67,0.6);
    }
    .auth-header {
        text-align: center;
        margin-bottom: 28px;
    }
    .auth-icon {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: linear-gradient(135deg,#0f75ff,#6f4bff);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 1.75rem;
    }
    .auth-title {
        font-size: 1.9rem;
        font-weight: 700;
        color: #101428;
        margin-bottom: 6px;
    }
    .auth-subtitle {
        font-size: 0.95rem;
        color: #6b7280;
    }
    .auth-group {
        margin-bottom: 18px;
    }
    .auth-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 6px;
    }
    .auth-input {
        width: 100%;
        border-radius: 14px;
        border: 1px solid rgba(15,22,45,0.15);
        padding: 12px 14px;
        font-size: 0.95rem;
        transition: border .2s ease, box-shadow .2s ease;
    }
    .auth-input:focus {
        outline: none;
        border-color: #0f75ff;
        box-shadow: 0 0 0 3px rgba(15,117,255,0.15);
    }
    .auth-error {
        margin-top: 6px;
        font-size: 0.85rem;
        color: #d14343;
    }
    .auth-remember {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        color: #424a5c;
        margin: 12px 0 20px;
    }
    .auth-btn {
        width: 100%;
        border: none;
        border-radius: 16px;
        padding: 13px 18px;
        font-size: 1rem;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(135deg,#111a3a,#0f75ff);
        cursor: pointer;
        transition: opacity .2s ease, transform .2s ease;
    }
    .auth-btn:hover {
        opacity: .95;
        transform: translateY(-1px);
    }
    .auth-footer {
        text-align: center;
        font-size: 0.92rem;
        margin-top: 18px;
        color: #606779;
    }
    .auth-link {
        color: #0f75ff;
        text-decoration: none;
        font-weight: 600;
    }
    .auth-link:hover { text-decoration: underline; }
</style>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-icon">🛒</div>
            <h2 class="auth-title">Connexion</h2>
            <p class="auth-subtitle">Connectez-vous pour publier des annonces</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="auth-group">
                <label for="email" class="auth-label">Email</label>
                <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" class="auth-input" placeholder="votre@email.com">
                @error('email')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-group">
                <label for="password" class="auth-label">Mot de passe</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required class="auth-input" placeholder="••••••••">
                @error('password')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <label class="auth-remember">
                <input id="remember" name="remember" type="checkbox">
                Se souvenir de moi
            </label>

            <button type="submit" class="auth-btn">Se connecter</button>

            <div class="auth-footer">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="auth-link">Créer un compte</a>
            </div>
        </form>
    </div>
</div>
@endsection

