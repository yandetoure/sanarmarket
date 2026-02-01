@extends('layouts.app')

@section('title', 'Créer une boutique - Sanar Market')

@section('content')
    <div class="bg-slate-50 min-h-screen pb-20 pt-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-12 text-center" data-aos="fade-down">
                <h1 class="text-3xl md:text-5xl font-display font-black text-slate-900 leading-tight">
                    Lancez votre <span class="text-gradient">Boutique Digitale</span>
                </h1>
                <p class="text-slate-500 font-medium mt-4 text-lg">Créez un espace professionnel pour présenter vos produits
                    à tout le campus.</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Form Column -->
                <div class="lg:col-span-2">
                    <div class="glass p-10 md:p-12 rounded-[3rem] border-white/60 shadow-2xl shadow-slate-200/50"
                        data-aos="fade-right">
                        <form method="POST" action="{{ route('boutiques.store') }}" enctype="multipart/form-data"
                            class="space-y-10">
                            @csrf

                            <!-- Section: Identité -->
                            <div class="space-y-8">
                                <div class="flex items-center space-x-4 mb-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold text-xs">
                                        1</div>
                                    <h2 class="text-xl font-display font-black text-slate-900">Identité Visuelle</h2>
                                </div>

                                <div class="space-y-6">
                                    <div>
                                        <label for="name"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Nom
                                            de l'enseigne *</label>
                                        <input type="text" id="name" name="name" required value="{{ old('name') }}"
                                            class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-black transition-all placeholder-slate-300 text-xl"
                                            placeholder="Ex: Sanar Luxury Boutique">
                                        @error('name') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="cover_image"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Bannière
                                            de la boutique</label>
                                        <div class="relative group">
                                            <input type="file" name="cover_image" id="cover_image" accept="image/*"
                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                            <div
                                                class="glass-light p-10 rounded-3xl border-2 border-dashed border-slate-200 group-hover:border-primary-300 group-hover:bg-primary-50/10 transition-all text-center">
                                                <div
                                                    class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 group-hover:bg-primary-100 group-hover:text-primary-600 transition-all text-slate-400 group-hover:text-primary-600">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <p class="text-sm font-black text-slate-900">Sélectionnez une image de
                                                    couverture</p>
                                                <p
                                                    class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">
                                                    Format optimal 16:9 (2Mo max)</p>
                                            </div>
                                        </div>
                                        @error('cover_image') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}
                                        </p> @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="border-slate-100">

                            <!-- Section: Présentation -->
                            <div class="space-y-8">
                                <div class="flex items-center space-x-4 mb-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold text-xs">
                                        2</div>
                                    <h2 class="text-xl font-display font-black text-slate-900">Présentation & Contact</h2>
                                </div>

                                <div class="space-y-6">
                                    <div>
                                        <label for="description"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">À
                                            propos de la boutique</label>
                                        <textarea id="description" name="description" rows="5"
                                            class="w-full glass-light p-5 rounded-3xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-700 font-medium leading-relaxed transition-all placeholder-slate-300"
                                            placeholder="Décrivez votre univers, vos marques préférées, vos délais de livraison..."></textarea>
                                        @error('description') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}
                                        </p> @enderror
                                    </div>

                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="address"
                                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Adresse
                                                / Localisation</label>
                                            <input type="text" id="address" name="address" value="{{ old('address') }}"
                                                class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-bold transition-all"
                                                placeholder="Ex: Village C, Chambre 102">
                                            @error('address') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}
                                            </p> @enderror
                                        </div>
                                        <div>
                                            <label for="phone"
                                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">WhatsApp
                                                Pro</label>
                                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                                class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-bold transition-all"
                                                placeholder="+221 77 000 00 00">
                                            @error('phone') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}
                                            </p> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-slate-100">

                            <!-- Section: Réseaux Sociaux -->
                            <div class="space-y-8">
                                <div class="flex items-center space-x-4 mb-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold text-xs">
                                        3</div>
                                    <h2 class="text-xl font-display font-black text-slate-900">Présence Sociale</h2>
                                </div>

                                <div class="grid md:grid-cols-2 gap-6">
                                    <div class="relative">
                                        <label
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Instagram</label>
                                        <input type="url" name="social_links[instagram]"
                                            value="{{ old('social_links.instagram') }}"
                                            class="w-full glass-light p-4 rounded-xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-600 font-bold transition-all text-sm"
                                            placeholder="https://instagram.com/...">
                                    </div>
                                    <div class="relative">
                                        <label
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Facebook</label>
                                        <input type="url" name="social_links[facebook]"
                                            value="{{ old('social_links.facebook') }}"
                                            class="w-full glass-light p-4 rounded-xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-600 font-bold transition-all text-sm"
                                            placeholder="https://facebook.com/...">
                                    </div>
                                    <div class="relative">
                                        <label
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Site
                                            Web</label>
                                        <input type="url" name="social_links[website]"
                                            value="{{ old('social_links.website') }}"
                                            class="w-full glass-light p-4 rounded-xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-600 font-bold transition-all text-sm"
                                            placeholder="https://...">
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col md:flex-row gap-4 pt-6">
                                <x-button type="submit" variant="primary" size="lg"
                                    class="flex-1 shadow-2xl shadow-primary-500/30">Lancer ma boutique</x-button>
                                <x-button href="{{ route('dashboard.boutiques') }}" variant="secondary" size="lg"
                                    class="md:w-48 bg-white">Plus tard</x-button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <div class="sticky top-32 space-y-8">
                        <!-- Why Boutique -->
                        <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-slate-200/50"
                            data-aos="fade-left">
                            <div
                                class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 mb-6 font-black text-xl">
                                🚀</div>
                            <h4 class="text-lg font-display font-black text-slate-900 mb-2">Pourquoi créer une boutique ?
                            </h4>
                            <ul class="text-xs text-slate-500 space-y-3 font-medium">
                                <li class="flex items-center space-x-2">
                                    <span class="w-1.5 h-1.5 bg-indigo-400 rounded-full"></span>
                                    <span>URL personnalisée pour votre boutique</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <span class="w-1.5 h-1.5 bg-indigo-400 rounded-full"></span>
                                    <span>Gestion d'inventaire simplifiée</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <span class="w-1.5 h-1.5 bg-indigo-400 rounded-full"></span>
                                    <span>Statistiques de vues et clics</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Safety -->
                        <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-slate-100/50"
                            data-aos="fade-left" data-aos-delay="100">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Engagement</p>
                            <p class="text-xs text-slate-500 font-medium leading-relaxed italic">"Je m'engage à fournir des
                                produits conformes et à respecter les clients du Campus."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection