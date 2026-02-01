@extends('layouts.app')

@section('title', 'Configurer les horaires - ' . $restaurant->name . ' - Sanar Market')

@section('content')
    <div class="bg-slate-50 min-h-screen pb-20 pt-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-12 text-center" data-aos="fade-down">
                <h1 class="text-3xl md:text-5xl font-display font-black text-slate-900 leading-tight">
                    Planifiez votre <span class="text-gradient">Disponibilité</span>
                </h1>
                <p class="text-slate-500 font-medium mt-4 text-lg">Informez les étudiants de vos horaires pour optimiser vos
                    commandes.</p>
            </div>

            <div class="glass p-10 md:p-12 rounded-[3rem] border-white/60 shadow-2xl shadow-slate-200/50"
                data-aos="fade-up">
                <form method="POST" action="{{ route('restaurants.schedules.store', $restaurant) }}"
                    x-data="{ isClosed: {{ old('is_closed', '0') }} == '1' }" class="space-y-10">
                    @csrf

                    <div class="space-y-8">
                        <div class="grid md:grid-cols-2 gap-8">
                            <div>
                                <label for="day_of_week"
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Jour
                                    de la semaine *</label>
                                <select id="day_of_week" name="day_of_week" required
                                    class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-900 font-bold appearance-none transition-all">
                                    <option value="">Sélectionner un jour</option>
                                    <option value="0" {{ old('day_of_week') == '0' ? 'selected' : '' }}>Lundi</option>
                                    <option value="1" {{ old('day_of_week') == '1' ? 'selected' : '' }}>Mardi</option>
                                    <option value="2" {{ old('day_of_week') == '2' ? 'selected' : '' }}>Mercredi</option>
                                    <option value="3" {{ old('day_of_week') == '3' ? 'selected' : '' }}>Jeudi</option>
                                    <option value="4" {{ old('day_of_week') == '4' ? 'selected' : '' }}>Vendredi</option>
                                    <option value="5" {{ old('day_of_week') == '5' ? 'selected' : '' }}>Samedi</option>
                                    <option value="6" {{ old('day_of_week') == '6' ? 'selected' : '' }}>Dimanche</option>
                                </select>
                                @error('day_of_week') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="is_closed"
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Statut
                                    du jour</label>
                                <select id="is_closed" name="is_closed" x-model="isClosed"
                                    class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-900 font-bold appearance-none transition-all">
                                    <option value="0">Ouvert (Service actif)</option>
                                    <option value="1">Fermé (Repos)</option>
                                </select>
                                @error('is_closed') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Open Hours UI -->
                        <div x-show="!isClosed" x-transition class="space-y-8">
                            <div class="grid md:grid-cols-2 gap-8">
                                <div>
                                    <label for="opens_at"
                                        class="text-[10px] font-black text-orange-500 uppercase tracking-widest block mb-3">Ouverture</label>
                                    <input type="time" id="opens_at" name="opens_at" :required="!isClosed"
                                        value="{{ old('opens_at') }}"
                                        class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-900 font-black transition-all">
                                    @error('opens_at') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="closes_at"
                                        class="text-[10px] font-black text-orange-500 uppercase tracking-widest block mb-3">Fermeture</label>
                                    <input type="time" id="closes_at" name="closes_at" :required="!isClosed"
                                        value="{{ old('closes_at') }}"
                                        class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-900 font-black transition-all">
                                    @error('closes_at') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Closed Message -->
                        <div x-show="isClosed" x-transition
                            class="glass-light p-10 rounded-[2.5rem] border-amber-100 bg-amber-50/20 text-center">
                            <div
                                class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 mx-auto mb-4 font-black text-2xl">
                                💤</div>
                            <h4 class="text-lg font-display font-black text-amber-900 mb-2">Jour de Fermeture</h4>
                            <p class="text-sm text-amber-700 font-medium">Le restaurant sera affiché comme "Fermé" pour les
                                étudiants ce jour-là. Aucune commande ne pourra être passée.</p>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row gap-4 pt-6">
                        <x-button type="submit" variant="primary" size="lg"
                            class="flex-1 bg-orange-600 hover:bg-orange-700 shadow-2xl shadow-orange-500/30 border-none">Enregistrer
                            l'horaire</x-button>
                        <x-button href="{{ route('restaurants.manage', $restaurant) }}" variant="secondary" size="lg"
                            class="md:w-48 bg-white">Annuler</x-button>
                    </div>
                </form>
            </div>

            <!-- Tip -->
            <div class="mt-12 text-center" data-aos="fade-up">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 italic">Un planning précis
                    fidèle à la réalité renforce la confiance de vos clients.</p>
            </div>
        </div>
    </div>
@endsection