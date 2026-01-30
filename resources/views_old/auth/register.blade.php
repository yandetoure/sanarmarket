@extends('layouts.app')

@section('title', 'Inscription - Sanar Market')

@section('content')
<style>
    .register-wrapper {
        min-height: calc(100vh - 120px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 16px;
        background: linear-gradient(135deg,#f5f7ff,#f0f4ff);
    }
    .register-card {
        width: 100%;
        max-width: 460px;
        background: #fff;
        border-radius: 28px;
        padding: 44px 40px;
        box-shadow: 0 50px 90px -60px rgba(9,11,34,0.65);
    }
    .register-header {
        text-align: center;
        margin-bottom: 30px;
    }
    .register-icon {
        width: 66px;
        height: 66px;
        border-radius: 20px;
        background: linear-gradient(135deg,#0f75ff,#6f4bff);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 1.9rem;
    }
    .register-title {
        font-size: 2rem;
        font-weight: 700;
        color: #0d1837;
        margin-bottom: 8px;
    }
    .register-subtitle {
        font-size: 0.95rem;
        color: #6a7390;
    }
    .register-group {
        margin-bottom: 18px;
    }
    .register-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: #1c243c;
        margin-bottom: 6px;
    }
    .register-input {
        width: 100%;
        border-radius: 15px;
        border: 1px solid rgba(14,18,53,0.15);
        padding: 12px 14px;
        font-size: 0.95rem;
        transition: border .2s ease, box-shadow .2s ease;
    }
    .register-input:focus {
        outline: none;
        border-color: #6f4bff;
        box-shadow: 0 0 0 3px rgba(111,75,255,0.15);
    }
    .register-error {
        margin-top: 6px;
        font-size: 0.85rem;
        color: #d14343;
    }
    .register-btn {
        width: 100%;
        border: none;
        border-radius: 18px;
        padding: 14px 18px;
        font-size: 1rem;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(135deg,#111a3a,#0f75ff);
        cursor: pointer;
        transition: opacity .2s ease, transform .2s ease;
        margin-top: 6px;
    }
    .register-btn:hover {
        opacity: .95;
        transform: translateY(-1px);
    }
    .register-footer {
        text-align: center;
        font-size: 0.92rem;
        margin-top: 18px;
        color: #626b83;
    }
    .register-link {
        color: #0f75ff;
        text-decoration: none;
        font-weight: 600;
    }
    .register-link:hover { text-decoration: underline; }
</style>

<div class="register-wrapper">
    <div class="register-card">
        <div class="register-header">
            <div class="register-icon">🛒</div>
            <h2 class="register-title">Créer un compte</h2>
            <p class="register-subtitle">Rejoignez la communauté des étudiants</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="register-group">
                <label for="name" class="register-label">Nom complet</label>
                <input id="name" name="name" type="text" autocomplete="name" required value="{{ old('name') }}" class="register-input" placeholder="Jean Dupont">
                @error('name')
                    <p class="register-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="register-group">
                <label for="email" class="register-label">Email</label>
                <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" class="register-input" placeholder="votre@email.com">
                @error('email')
                    <p class="register-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="register-group">
                <label for="password" class="register-label">Mot de passe</label>
                <input id="password" name="password" type="password" autocomplete="new-password" required class="register-input" placeholder="••••••••">
                @error('password')
                    <p class="register-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="register-group">
                <label for="password_confirmation" class="register-label">Confirmer le mot de passe</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="register-input" placeholder="••••••••">
            </div>

            <button type="submit" class="register-btn">Créer un compte</button>

            <div class="register-footer">
                Déjà un compte ?
                <a href="{{ route('login') }}" class="register-link">Se connecter</a>
            </div>
        </form>
    </div>
</div>
@endsection

