@extends('layouts.app')

@section('title', 'Créer un restaurant - Sanar Market')

@section('content')
    <div class="bg-slate-50 min-h-screen pb-20 pt-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-12 text-center" data-aos="fade-down">
                <h1 class="text-3xl md:text-5xl font-display font-black text-slate-900 leading-tight">
                    Ouvrez votre <span class="text-gradient">Espace Gourmand</span>
                </h1>
                <p class="text-slate-500 font-medium mt-4 text-lg">Partagez votre passion pour la cuisine et attirez les
                    gourmets du campus.</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Form Column -->
                <div class="lg:col-span-2">
                    <div class="glass p-10 md:p-12 rounded-[3rem] border-white/60 shadow-2xl shadow-slate-200/50"
                        data-aos="fade-right">
                        <form method="POST" action="{{ route('restaurants.store') }}" enctype="multipart/form-data"
                            class="space-y-10">
                            @csrf

                            <!-- Section: Identité -->
                            <div class="space-y-8">
                                <div class="flex items-center space-x-4 mb-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-bold text-xs shadow-lg shadow-orange-100">
                                        1</div>
                                    <h2 class="text-xl font-display font-black text-slate-900">Concept Culinaire</h2>
                                </div>

                                <div class="space-y-6">
                                    <div>
                                        <label for="name"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Nom
                                            du restaurant *</label>
                                        <input type="text" id="name" name="name" required value="{{ old('name') }}"
                                            class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-900 font-black transition-all placeholder-slate-300 text-xl"
                                            placeholder="Ex: Le Festin de Sanar">
                                        @error('name') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="cover_image"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Photo
                                            de couverture (Ambiance)</label>
                                        <div class="relative group">
                                            <input type="file" name="cover_image" id="cover_image" accept="image/*"
                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                            <div
                                                class="glass-light p-10 rounded-3xl border-2 border-dashed border-slate-200 group-hover:border-orange-300 group-hover:bg-orange-50/10 transition-all text-center">
                                                <div
                                                    class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 group-hover:bg-orange-100 group-hover:text-orange-600 transition-all text-slate-400 group-hover:text-orange-600">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                </div>
                                                <p class="text-sm font-black text-slate-900">Cliquez pour ajouter une photo
                                                </p>
                                                <p
                                                    class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">
                                                    Plats ou décoration (2Mo max)</p>
                                            </div>
                                        </div>
                                        @error('cover_image') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}
                                        </p> @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="border-slate-100">

                            <!-- Section: Menu & Style -->
                            <div class="space-y-8">
                                <div class="flex items-center space-x-4 mb-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-bold text-xs shadow-lg shadow-orange-100">
                                        2</div>
                                    <h2 class="text-xl font-display font-black text-slate-900">Spécialités & Tarifs</h2>
                                </div>

                                <div class="space-y-6">
                                    <div>
                                        <label for="description"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Histoire
                                            & Menu</label>
                                        <textarea id="description" name="description" rows="5"
                                            class="w-full glass-light p-5 rounded-3xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-700 font-medium leading-relaxed transition-all placeholder-slate-300"
                                            placeholder="Racontez votre passion cuisine, listez vos plats signature, options végétariennes, etc."></textarea>
                                        @error('description') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}
                                        </p> @enderror
                                    </div>

                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="cuisine_type"
                                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Type
                                                de cuisine</label>
                                            <input type="text" id="cuisine_type" name="cuisine_type"
                                                value="{{ old('cuisine_type') }}"
                                                class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-900 font-bold transition-all"
                                                placeholder="Ex: Sénégalaise moderne, Fast-food...">
                                            @error('cuisine_type') <p class="mt-2 text-xs text-red-500 font-bold">
                                            {{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label for="price_range"
                                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Gamme
                                                de prix</label>
                                            <select id="price_range" name="price_range"
                                                class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-900 font-bold appearance-none transition-all">
                                                <option value="">Sélectionner</option>
                                                <option value="€" {{ old('price_range') == '€' ? 'selected' : '' }}>FCFA -
                                                    Économique</option>
                                                <option value="€€" {{ old('price_range') == '€€' ? 'selected' : '' }}>FCFA+ -
                                                    Modéré</option>
                                                <option value="€€€" {{ old('price_range') == '€€€' ? 'selected' : '' }}>FCFA++
                                                    - Premium</option>
                                            </select>
                                            @error('price_range') <p class="mt-2 text-xs text-red-500 font-bold">
                                            {{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-slate-100">

                            <!-- Section: Localisation -->
                            <div class="space-y-8">
                                <div class="flex items-center space-x-4 mb-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-bold text-xs shadow-lg shadow-orange-100">
                                        3</div>
                                    <h2 class="text-xl font-display font-black text-slate-900">Accès</h2>
                                </div>

                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="address"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Emplacement</label>
                                        <input type="text" id="address" name="address" value="{{ old('address') }}"
                                            class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-900 font-bold transition-all"
                                            placeholder="Ex: Derrière le Restau 1, Sanar">
                                        @error('address') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="phone"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Téléphone
                                            (Commandes)</label>
                                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                            class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-900 font-bold transition-all">
                                        @error('phone') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col md:flex-row gap-4 pt-6">
                                <x-button type="submit" variant="primary" size="lg"
                                    class="flex-1 bg-orange-600 hover:bg-orange-700 shadow-2xl shadow-orange-500/30 border-none">Ouvrir
                                    mon restaurant</x-button>
                                <x-button href="{{ route('dashboard.restaurants') }}" variant="secondary" size="lg"
                                    class="md:w-48 bg-white">Annuler</x-button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <div class="sticky top-32 space-y-8">
                        <!-- Chef Tip -->
                        <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-orange-50/50"
                            data-aos="fade-left">
                            <div
                                class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600 mb-6 font-black text-xl">
                                👨‍🍳</div>
                            <h4 class="text-lg font-display font-black text-slate-900 mb-2">Conseil du Chef</h4>
                            <p class="text-xs text-slate-500 font-medium leading-relaxed">Pensez à ajouter vos horaires
                                d'ouverture et votre menu détaillé une fois le restaurant créé pour que les étudiants
                                puissent commander plus facilement.</p>
                        </div>

                        <!-- Marketplace Integration -->
                        <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-slate-100/50"
                            data-aos="fade-left" data-aos-delay="100">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Menu Digital</p>
                            <p class="text-xs text-slate-500 font-medium leading-relaxed italic">"En créant un restaurant,
                                vous accédez à un outil de gestion de menu moderne pour mettre à jour vos plats en temps
                                réel."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection