@extends('layouts.app')

@section('title', 'Modifier ' . $boutique->name . ' - Sanar Market')

@section('content')
    <div class="bg-slate-50 min-h-screen pb-20 pt-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-12 text-center" data-aos="fade-down">
                <h1 class="text-3xl md:text-5xl font-display font-black text-slate-900 leading-tight">
                    Gérez votre <span class="text-gradient">Boutique</span>
                </h1>
                <p class="text-slate-500 font-medium mt-4 text-lg">Mettez à jour les informations de votre enseigne pour
                    rester au sommet.</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Form Column -->
                <div class="lg:col-span-2">
                    <div class="glass p-10 md:p-12 rounded-[3rem] border-white/60 shadow-2xl shadow-slate-200/50"
                        data-aos="fade-right">
                        <form method="POST" action="{{ route('boutiques.update', $boutique) }}"
                            enctype="multipart/form-data" class="space-y-10">
                            @csrf
                            @method('PUT')

                            <!-- Section: Identité -->
                            <div class="space-y-8">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold text-xs">
                                            1</div>
                                        <h2 class="text-xl font-display font-black text-slate-900">Identité & Statut</h2>
                                    </div>
                                    <x-badge variant="{{ $boutique->status === 'active' ? 'emerald' : 'orange' }}"
                                        size="sm">{{ ucfirst($boutique->status) }}</x-badge>
                                </div>

                                <div class="space-y-6">
                                    <div>
                                        <label for="name"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Nom
                                            de l'enseigne *</label>
                                        <input type="text" id="name" name="name" required
                                            value="{{ old('name', $boutique->name) }}"
                                            class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-black transition-all placeholder-slate-300 text-xl"
                                            placeholder="Ex: Sanar Luxury Boutique">
                                        @error('name') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="status"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Statut
                                            de la boutique</label>
                                        <select id="status" name="status" required
                                            class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-bold appearance-none transition-all">
                                            <option value="draft" {{ old('status', $boutique->status) == 'draft' ? 'selected' : '' }}>Brouillon (Non visible)</option>
                                            <option value="pending" {{ old('status', $boutique->status) == 'pending' ? 'selected' : '' }}>En attente de validation</option>
                                            <option value="active" {{ old('status', $boutique->status) == 'active' ? 'selected' : '' }}>Active (En ligne)</option>
                                        </select>
                                        @error('status') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="cover_image"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Changer
                                            la bannière</label>
                                        @if($boutique->cover_image)
                                            <div class="rounded-3xl overflow-hidden mb-6 aspect-video shadow-lg relative group">
                                                <img src="{{ asset('storage/' . $boutique->cover_image) }}"
                                                    alt="{{ $boutique->name }}" class="w-full h-full object-cover">
                                                <div
                                                    class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <span class="text-white text-xs font-black uppercase tracking-widest">Image
                                                        actuelle</span>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="relative group">
                                            <input type="file" name="cover_image" id="cover_image" accept="image/*"
                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                            <div
                                                class="glass-light p-8 rounded-3xl border-2 border-dashed border-slate-200 group-hover:border-primary-300 group-hover:bg-primary-50/10 transition-all text-center">
                                                <p class="text-sm font-black text-slate-900 leading-none">Remplacer l'image
                                                    de couverture</p>
                                                <p
                                                    class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">
                                                    Laisser vide pour conserver l'actuelle</p>
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
                                            class="w-full glass-light p-5 rounded-3xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-700 font-medium leading-relaxed transition-all">{{ old('description', $boutique->description) }}</textarea>
                                        @error('description') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}
                                        </p> @enderror
                                    </div>

                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="address"
                                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Adresse
                                                / Localisation</label>
                                            <input type="text" id="address" name="address"
                                                value="{{ old('address', $boutique->address) }}"
                                                class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-bold transition-all">
                                            @error('address') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}
                                            </p> @enderror
                                        </div>
                                        <div>
                                            <label for="phone"
                                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">WhatsApp
                                                Pro</label>
                                            <input type="tel" id="phone" name="phone"
                                                value="{{ old('phone', $boutique->phone) }}"
                                                class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-bold transition-all">
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
                                            value="{{ old('social_links.instagram', $boutique->social_links['instagram'] ?? '') }}"
                                            class="w-full glass-light p-4 rounded-xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-600 font-bold transition-all text-sm">
                                    </div>
                                    <div class="relative">
                                        <label
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Facebook</label>
                                        <input type="url" name="social_links[facebook]"
                                            value="{{ old('social_links.facebook', $boutique->social_links['facebook'] ?? '') }}"
                                            class="w-full glass-light p-4 rounded-xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-600 font-bold transition-all text-sm">
                                    </div>
                                    <div class="relative">
                                        <label
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Site
                                            Web</label>
                                        <input type="url" name="social_links[website]"
                                            value="{{ old('social_links.website', $boutique->social_links['website'] ?? '') }}"
                                            class="w-full glass-light p-4 rounded-xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-600 font-bold transition-all text-sm">
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col md:flex-row gap-4 pt-6">
                                <x-button type="submit" variant="primary" size="lg"
                                    class="flex-1 shadow-2xl shadow-primary-500/30">Enregistrer les modifications</x-button>
                                <x-button href="{{ route('boutiques.manage', $boutique) }}" variant="secondary" size="lg"
                                    class="md:w-48 bg-white">Annuler</x-button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <div class="sticky top-32 space-y-8">
                        <!-- Preview Card -->
                        <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-slate-200/50 text-center"
                            data-aos="fade-left">
                            <div
                                class="w-20 h-20 rounded-[2rem] bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center text-white font-display font-black text-3xl mx-auto mb-6 shadow-lg">
                                {{ strtoupper(substr($boutique->name, 0, 1)) }}
                            </div>
                            <h4 class="text-xl font-display font-black text-slate-900 mb-2">{{ $boutique->name }}</h4>
                            <p class="text-xs text-slate-400 font-medium mb-6">Boutique ID: #{{ $boutique->id }}</p>
                            <x-button href="{{ route('boutiques.public.show', $boutique->slug) }}" target="_blank"
                                variant="secondary" size="sm" class="w-full bg-white">Aperçu Public</x-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection