@extends('layouts.app')

@section('title', 'Ajouter un plat - ' . $restaurant->name . ' - Sanar Market')

@section('content')
    <div class="bg-slate-50 min-h-screen pb-20 pt-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-12 text-center" data-aos="fade-down">
                <h1 class="text-3xl md:text-5xl font-display font-black text-slate-900 leading-tight">
                    Ajoutez une <span class="text-gradient">Création</span> au Menu
                </h1>
                <p class="text-slate-500 font-medium mt-4 text-lg">Présentez vos nouveaux plats avec élégance pour séduire
                    tout le campus.</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Form Column -->
                <div class="lg:col-span-2">
                    <div class="glass p-10 md:p-12 rounded-[3rem] border-white/60 shadow-2xl shadow-slate-200/50"
                        data-aos="fade-right">
                        <form method="POST" action="{{ route('restaurants.menu-items.store', $restaurant) }}"
                            class="space-y-10">
                            @csrf

                            <!-- Section: Le Plat -->
                            <div class="space-y-8" x-data="{ availability: '{{ old('availability_type', 'daily') }}' }">
                                <div class="flex items-center space-x-4 mb-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-bold text-xs shadow-lg shadow-orange-100">
                                        1</div>
                                    <h2 class="text-xl font-display font-black text-slate-900">Le Plat</h2>
                                </div>

                                <div class="space-y-6">
                                    <div>
                                        <label for="title"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Intitulé
                                            du plat *</label>
                                        <input type="text" id="title" name="title" required value="{{ old('title') }}"
                                            class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-900 font-black transition-all placeholder-slate-300 text-xl"
                                            placeholder="Ex: Thieboudienne Royal">
                                        @error('title') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="description"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Ingrédients
                                            & Histoire</label>
                                        <textarea id="description" name="description" rows="4"
                                            class="w-full glass-light p-5 rounded-3xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-700 font-medium leading-relaxed transition-all placeholder-slate-300"
                                            placeholder="Décrivez les saveurs, les accompagnements et ce qui rend ce plat spécial..."></textarea>
                                        @error('description') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}
                                        </p> @enderror
                                    </div>

                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="price"
                                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Prix
                                                de vente (FCFA) *</label>
                                            <div class="relative">
                                                <input type="number" id="price" name="price" step="0.01" min="0" required
                                                    value="{{ old('price') }}"
                                                    class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-900 font-black transition-all">
                                                <span
                                                    class="absolute right-5 top-1/2 -translate-y-1/2 font-black text-slate-300 text-xs text-xs">FCFA</span>
                                            </div>
                                            @error('price') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}
                                            </p> @enderror
                                        </div>
                                        <div>
                                            <label for="is_available"
                                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Disponibilité
                                                Immédiate</label>
                                            <select id="is_available" name="is_available"
                                                class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-900 font-bold appearance-none transition-all">
                                                <option value="1" {{ old('is_available', '1') == '1' ? 'selected' : '' }}>En
                                                    Cuisine (Disponible)</option>
                                                <option value="0" {{ old('is_available') == '0' ? 'selected' : '' }}>Épuisé
                                                    (Indisponible)</option>
                                            </select>
                                            @error('is_available') <p class="mt-2 text-xs text-red-500 font-bold">
                                            {{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-slate-100">

                            <!-- Section: Planning -->
                            <div class="space-y-8" x-data="{ availability: '{{ old('availability_type', 'daily') }}' }">
                                <div class="flex items-center space-x-4 mb-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-bold text-xs shadow-lg shadow-orange-100">
                                        2</div>
                                    <h2 class="text-xl font-display font-black text-slate-900">Planification</h2>
                                </div>

                                <div class="space-y-6">
                                    <div>
                                        <label for="availability_type"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Fréquence
                                            au Menu</label>
                                        <select id="availability_type" name="availability_type" x-model="availability"
                                            class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-900 font-bold appearance-none transition-all">
                                            <option value="daily">Signature (Tous les jours)</option>
                                            <option value="weekly">Jour du Marché (Hebdomadaire)</option>
                                            <option value="time_range">Service Spécial (Plage Horaire)</option>
                                        </select>
                                        @error('availability_type') <p class="mt-2 text-xs text-red-500 font-bold">
                                        {{ $message }}</p> @enderror
                                    </div>

                                    <!-- Weekly UI -->
                                    <div x-show="availability === 'weekly'" x-transition
                                        class="glass-light p-8 rounded-[2rem] border-orange-100">
                                        <label for="day_of_week"
                                            class="text-[10px] font-black text-orange-500 uppercase tracking-widest block mb-3">Quel
                                            jour ?</label>
                                        <select id="day_of_week" name="day_of_week"
                                            class="w-full glass-light p-4 rounded-xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-900 font-bold appearance-none">
                                            <option value="0" {{ old('day_of_week') == '0' ? 'selected' : '' }}>Lundi</option>
                                            <option value="1" {{ old('day_of_week') == '1' ? 'selected' : '' }}>Mardi</option>
                                            <option value="2" {{ old('day_of_week') == '2' ? 'selected' : '' }}>Mercredi
                                            </option>
                                            <option value="3" {{ old('day_of_week') == '3' ? 'selected' : '' }}>Jeudi</option>
                                            <option value="4" {{ old('day_of_week') == '4' ? 'selected' : '' }}>Vendredi
                                            </option>
                                            <option value="5" {{ old('day_of_week') == '5' ? 'selected' : '' }}>Samedi
                                            </option>
                                            <option value="6" {{ old('day_of_week') == '6' ? 'selected' : '' }}>Dimanche
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Time Range UI -->
                                    <div x-show="availability === 'time_range'" x-transition
                                        class="glass-light p-8 rounded-[2rem] border-orange-100">
                                        <div class="grid md:grid-cols-2 gap-6">
                                            <div>
                                                <label for="starts_at"
                                                    class="text-[10px] font-black text-orange-500 uppercase tracking-widest block mb-3">Heure
                                                    de début</label>
                                                <input type="time" id="starts_at" name="starts_at"
                                                    value="{{ old('starts_at') }}"
                                                    class="w-full glass-light p-4 rounded-xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-900 font-bold">
                                            </div>
                                            <div>
                                                <label for="ends_at"
                                                    class="text-[10px] font-black text-orange-500 uppercase tracking-widest block mb-3">Heure
                                                    de fin</label>
                                                <input type="time" id="ends_at" name="ends_at" value="{{ old('ends_at') }}"
                                                    class="w-full glass-light p-4 rounded-xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-900 font-bold">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col md:flex-row gap-4 pt-6">
                                <x-button type="submit" variant="primary" size="lg"
                                    class="flex-1 bg-orange-600 hover:bg-orange-700 shadow-2xl shadow-orange-500/30 border-none">Ajouter
                                    cette création</x-button>
                                <x-button href="{{ route('restaurants.manage', $restaurant) }}" variant="secondary"
                                    size="lg" class="md:w-48 bg-white">Annuler</x-button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <div class="sticky top-32 space-y-8">
                        <!-- Restaurant Badge -->
                        <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-orange-100/30 text-center"
                            data-aos="fade-left">
                            <div
                                class="w-16 h-16 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-600 font-display font-black text-xl mx-auto mb-4 border border-white">
                                {{ strtoupper(substr($restaurant->name, 0, 1)) }}
                            </div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Destiné au menu
                                de</p>
                            <h4 class="text-base font-display font-black text-slate-900 mb-6">{{ $restaurant->name }}</h4>
                            <div class="h-px bg-slate-100 w-10 mx-auto mb-6"></div>
                            <p class="text-[10px] font-bold text-slate-500 leading-relaxed italic">"Une description qui
                                donne l'eau à la bouche capte 3x plus d'attention."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection