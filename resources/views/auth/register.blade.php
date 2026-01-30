@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden bg-slate-50">
        <!-- Decorative Blobs -->
        <div
            class="absolute top-0 -left-4 w-72 h-72 bg-primary-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
        </div>
        <div
            class="absolute top-0 -right-4 w-72 h-72 bg-secondary-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-8 left-20 w-72 h-72 bg-emerald-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000">
        </div>

        <div class="max-w-md w-full space-y-8 relative z-10" data-aos="fade-up">
            <div class="text-center">
                <h2 class="mt-6 text-4xl font-display font-black text-slate-900 tracking-tight">
                    Créez votre <span class="text-gradient">Compte</span>.
                </h2>
                <p class="mt-2 text-sm text-slate-500 font-medium">
                    Rejoignez la plus grande communauté étudiante de Sanar
                </p>
            </div>

            <div class="glass p-8 md:p-10 rounded-[2.5rem] shadow-2xl border-white/40">
                <form class="space-y-5" action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="space-y-1.5">
                        <label for="name" class="text-sm font-bold text-slate-700 ml-1">Nom complet</label>
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-500 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input id="name" name="name" type="text" autocomplete="name" required
                                class="block w-full pl-11 pr-4 py-3 bg-white/50 border border-slate-200 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all sm:text-sm"
                                placeholder="Jean Dupont" value="{{ old('name') }}">
                        </div>
                        @error('name')
                            <p class="text-xs font-bold text-red-500 mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="email" class="text-sm font-bold text-slate-700 ml-1">Adresse Email</label>
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-500 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                    </path>
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="block w-full pl-11 pr-4 py-3 bg-white/50 border border-slate-200 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all sm:text-sm"
                                placeholder="nom@exemple.com" value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <p class="text-xs font-bold text-red-500 mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label for="password" class="text-sm font-bold text-slate-700 ml-1">Mot de passe</label>
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-500 transition-colors">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                </div>
                                <input id="password" name="password" type="password" autocomplete="new-password" required
                                    class="block w-full pl-11 pr-4 py-3 bg-white/50 border border-slate-200 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all sm:text-sm"
                                    placeholder="••••••••">
                            </div>
                            @error('password')
                                <p class="text-xs font-bold text-red-500 mt-1 ml-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="password_confirmation"
                                class="text-sm font-bold text-slate-700 ml-1">Confirmation</label>
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-500 transition-colors">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                </div>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    autocomplete="new-password" required
                                    class="block w-full pl-11 pr-4 py-3 bg-white/50 border border-slate-200 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all sm:text-sm"
                                    placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <x-button type="submit" variant="primary" size="lg" class="w-full">
                            Créer un compte
                        </x-button>
                    </div>
                </form>

                <div class="mt-8 text-center border-t border-slate-100 pt-6">
                    <p class="text-sm text-slate-500 font-medium">
                        Vous avez déjà un compte ?
                        <a href="{{ route('login') }}"
                            class="font-bold text-primary-600 hover:text-primary-500 transition-colors">
                            Se connecter ici
                        </a>
                    </p>
                </div>
            </div>

            <p class="text-center text-xs text-slate-400 font-medium">
                En s'inscrivant, vous acceptez nos <a href="#" class="underline hover:text-slate-600">Conditions
                    d'Utilisation</a> et notre <a href="#" class="underline hover:text-slate-600">Politique de
                    Confidentialité</a>.
            </p>
        </div>
    </div>

    <style>
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
@endsection