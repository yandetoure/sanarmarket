@extends('layouts.app')

@section('title', 'Modifier ' . $restaurant->name . ' - Sanar Market')

@section('content')
    <div class="bg-slate-50 min-h-screen pb-20 pt-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-12 text-center" data-aos="fade-down">
                <h1 class="text-3xl md:text-5xl font-display font-black text-slate-900 leading-tight">
                    Gérez votre <span class="text-gradient">Espace Gourmand</span>
                </h1>
                <p class="text-slate-500 font-medium mt-4 text-lg">Mettez à jour vos spécialités et informations pour
                    continuer à régaler le campus.</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Form Column -->
                <div class="lg:col-span-2">
                    <div class="glass p-10 md:p-12 rounded-[3rem] border-white/60 shadow-2xl shadow-slate-200/50"
                        data-aos="fade-right">
                        <form method="POST" action="{{ route('restaurants.update', $restaurant) }}"
                            enctype="multipart/form-data" class="space-y-10">
                            @csrf
                            @method('PUT')

                            <!-- Section: Identité -->
                            <div class="space-y-8">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-bold text-xs shadow-lg shadow-orange-100">
                                            1</div>
                                        <h2 class="text-xl font-display font-black text-slate-900">Concept & Statut</h2>
                                    </div>
                                    <x-badge variant="{{ $restaurant->status === 'active' ? 'emerald' : 'orange' }}"
                                        size="sm">{{ ucfirst($restaurant->status) }}</x-badge>
                                </div>

                                <div class="space-y-6">
                                    <div>
                                        <label for="name"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Nom
                                            du restaurant *</label>
                                        <input type="text" id="name" name="name" required
                                            value="{{ old('name', $restaurant->name) }}"
                                            class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-900 font-black transition-all placeholder-slate-300 text-xl"
                                            placeholder="Ex: Le Festin de Sanar">
                                        @error('name') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="status"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Statut
                                            opérationnel</label>
                                        <select id="status" name="status" required
                                            class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-900 font-bold appearance-none transition-all">
                                            <option value="draft" {{ old('status', $restaurant->status) == 'draft' ? 'selected' : '' }}>Brouillon (Fermé)</option>
                                            <option value="pending" {{ old('status', $restaurant->status) == 'pending' ? 'selected' : '' }}>En attente de validation</option>
                                            <option value="active" {{ old('status', $restaurant->status) == 'active' ? 'selected' : '' }}>Actif (Ouvert)</option>
                                        </select>
                                        @error('status') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="cover_image"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Changer
                                            la photo de couverture</label>
                                        @if($restaurant->cover_image)
                                            <div
                                                class="rounded-3xl overflow-hidden mb-6 aspect-video shadow-lg relative group border-2 border-white">
                                                <img src="{{ asset('storage/' . $restaurant->cover_image) }}"
                                                    alt="{{ $restaurant->name }}" class="w-full h-full object-cover">
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
                                                class="glass-light p-8 rounded-3xl border-2 border-dashed border-slate-200 group-hover:border-orange-300 group-hover:bg-orange-50/10 transition-all text-center">
                                                <p class="text-sm font-black text-slate-900 leading-none">Remplacer la photo
                                                </p>
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
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">À
                                            propos du restaurant</label>
                                        <textarea id="description" name="description" rows="5"
                                            class="w-full glass-light p-5 rounded-3xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-700 font-medium leading-relaxed transition-all">{{ old('description', $restaurant->description) }}</textarea>
                                        @error('description') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}
                                        </p> @enderror
                                    </div>

                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="cuisine_type"
                                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Type
                                                de cuisine</label>
                                            <input type="text" id="cuisine_type" name="cuisine_type"
                                                value="{{ old('cuisine_type', $restaurant->metadata['cuisine_type'] ?? '') }}"
                                                class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-orange-400 focus:ring-0 text-slate-900 font-bold transition-all">
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
                                                <option value="€" {{ old('price_range', $restaurant->metadata['price_range'] ?? '') == '€' ? 'selected' : '' }}>FCFA - Économique</option>
                                                <option value="€€" {{ old('price_range', $restaurant->metadata['price_range'] ?? '') == '€€' ? 'selected' : '' }}>
                                                    FCFA+ - Modéré</option>
                                                <option value="€€€" {{ old('price_range', $restaurant->metadata['price_range'] ?? '') == '€€€' ? 'selected' : '' }}>
                                                    FCFA++ - Premium</option>
                                            </select>
                                            @error('price_range') <p class="mt-2 text-xs text-red-500 font-bold">
                                            {{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col md:flex-row gap-4 pt-6">
                                <x-button type="submit" variant="primary" size="lg"
                                    class="flex-1 bg-orange-600 hover:bg-orange-700 shadow-2xl shadow-orange-500/30 border-none">Mettre
                                    à jour le restaurant</x-button>
                                <x-button href="{{ route('restaurants.manage', $restaurant) }}" variant="secondary"
                                    size="lg" class="md:w-48 bg-white">Annuler</x-button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <div class="sticky top-32 space-y-8">
                        <!-- Preview Card -->
                        <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-orange-100/50 text-center"
                            data-aos="fade-left">
                            <div
                                class="w-20 h-20 rounded-[2rem] bg-gradient-to-br from-orange-400 to-rose-500 flex items-center justify-center text-white font-display font-black text-3xl mx-auto mb-6 shadow-lg">
                                {{ strtoupper(substr($restaurant->name, 0, 1)) }}
                            </div>
                            <h4 class="text-xl font-display font-black text-slate-900 mb-2">{{ $restaurant->name }}</h4>
                            <p class="text-xs text-slate-400 font-medium mb-6">Resto ID: #{{ $restaurant->id }}</p>
                            <x-button href="{{ route('restaurants.public.show', $restaurant->slug) }}" target="_blank"
                                variant="secondary" size="sm" class="w-full bg-white">Aperçu Public</x-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection