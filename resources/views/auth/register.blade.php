@extends('layouts.app')

@section('title', 'Inscription - Sanar Market')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="w-16 h-16 bg-primary rounded-lg flex items-center justify-center mx-auto mb-4">
                <span class="text-primary-foreground text-2xl">🛒</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Créer un compte</h2>
            <p class="mt-2 text-sm text-muted-foreground">
                Rejoignez la communauté des étudiants
            </p>
        </div>

        <div class="bg-white py-8 px-6 shadow rounded-lg">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom complet
                    </label>
                    <input id="name" 
                           name="name" 
                           type="text" 
                           autocomplete="name" 
                           required 
                           value="{{ old('name') }}"
                           class="w-full px-3 py-2 border border-border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('name') border-red-500 @enderror"
                           placeholder="Jean Dupont">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <input id="email" 
                           name="email" 
                           type="email" 
                           autocomplete="email" 
                           required 
                           value="{{ old('email') }}"
                           class="w-full px-3 py-2 border border-border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror"
                           placeholder="votre@email.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Mot de passe
                    </label>
                    <input id="password" 
                           name="password" 
                           type="password" 
                           autocomplete="new-password" 
                           required
                           class="w-full px-3 py-2 border border-border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('password') border-red-500 @enderror"
                           placeholder="••••••••">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirmer le mot de passe
                    </label>
                    <input id="password_confirmation" 
                           name="password_confirmation" 
                           type="password" 
                           autocomplete="new-password" 
                           required
                           class="w-full px-3 py-2 border border-border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                           placeholder="••••••••">
                </div>

                <div>
                    <button type="submit" 
                            class="w-full bg-primary text-primary-foreground py-2 px-4 rounded-lg hover:bg-primary/90 transition-colors font-medium">
                        Créer un compte
                    </button>
                </div>

                <div class="text-center">
                    <p class="text-sm text-muted-foreground">
                        Déjà un compte ? 
                        <a href="{{ route('login') }}" class="text-primary hover:text-primary/80 font-medium">
                            Se connecter
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

