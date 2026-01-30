@extends('layouts.app')

@section('title', 'Modifier l\'annonce - Sanar Market')

@section('content')
    <div class="bg-slate-50 min-h-screen pb-20 pt-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-12 text-center" data-aos="fade-down">
                <h1 class="text-3xl md:text-5xl font-display font-black text-slate-900 leading-tight">
                    Optimisez votre <span class="text-gradient">Annonce</span>
                </h1>
                <p class="text-slate-500 font-medium mt-4 text-lg">Mettez à jour vos informations pour rester attractif
                    auprès des acheteurs.</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Form Column -->
                <div class="lg:col-span-2">
                    <div class="glass p-10 md:p-12 rounded-[3rem] border-white/60 shadow-2xl shadow-slate-200/50"
                        data-aos="fade-right">
                        <form method="POST" action="{{ route('announcements.update', $announcement) }}"
                            enctype="multipart/form-data" class="space-y-10">
                            @csrf
                            @method('PUT')

                            <!-- Section: Infos de base -->
                            <div class="space-y-8">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold text-xs">
                                            1</div>
                                        <h2 class="text-xl font-display font-black text-slate-900">L'essentiel</h2>
                                    </div>
                                    <x-badge variant="{{ $announcement->status === 'active' ? 'emerald' : 'orange' }}"
                                        size="sm">{{ ucfirst($announcement->status) }}</x-badge>
                                </div>

                                <div class="space-y-6">
                                    <div>
                                        <label for="title"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Titre
                                            de l'annonce</label>
                                        <input type="text" id="title" name="title" required
                                            value="{{ old('title', $announcement->title) }}"
                                            class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-bold transition-all placeholder-slate-300"
                                            placeholder="Ex: iPhone 13 Pro Max - État Neuf">
                                        @error('title') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="category_id"
                                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Catégorie</label>
                                            <select id="category_id" name="category_id" required
                                                class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-bold appearance-none transition-all">
                                                <option value="">Choisir une catégorie</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id', $announcement->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id') <p class="mt-2 text-xs text-red-500 font-bold">
                                            {{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label for="price"
                                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Prix
                                                (FCFA)</label>
                                            <div class="relative">
                                                <input type="number" id="price" name="price" required
                                                    value="{{ old('price', $announcement->price) }}"
                                                    class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-black transition-all">
                                                <span
                                                    class="absolute right-5 top-1/2 -translate-y-1/2 font-black text-slate-300 text-xs">FCFA</span>
                                            </div>
                                            @error('price') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}
                                            </p> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-slate-100">

                            <!-- Section: Détails -->
                            <div class="space-y-8">
                                <div class="flex items-center space-x-4 mb-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold text-xs">
                                        2</div>
                                    <h2 class="text-xl font-display font-black text-slate-900">Détails & Médias</h2>
                                </div>

                                <div class="space-y-6">
                                    <div>
                                        <label for="description"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Description</label>
                                        <textarea id="description" name="description" rows="5" required
                                            class="w-full glass-light p-5 rounded-3xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-700 font-medium leading-relaxed transition-all">{{ old('description', $announcement->description) }}</textarea>
                                        @error('description') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}
                                        </p> @enderror
                                    </div>

                                    <!-- Existing Media -->
                                    @if($announcement->media->count())
                                        <div>
                                            <label
                                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-4">Médias
                                                Actuels (Cliquez pour supprimer)</label>
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                                @foreach($announcement->media as $media)
                                                    <label
                                                        class="relative cursor-pointer group rounded-2xl overflow-hidden aspect-square border-2 border-transparent peer-checked:border-red-500 transition-all">
                                                        <input type="checkbox" name="removed_media[]" value="{{ $media->id }}"
                                                            class="sr-only peer">
                                                        <img src="{{ storage_url($media->path) }}"
                                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                                        <div
                                                            class="absolute inset-0 bg-red-600/60 flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity">
                                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div>
                                        @php
                                            $limit = $mediaLimit ?? 3;
                                            $accept = ($canUploadVideo ?? false) ? 'image/*,video/*' : 'image/*';
                                        @endphp
                                        <label
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Nouveaux
                                            Médias</label>
                                        <div class="relative group">
                                            <input type="file" name="media[]" id="media" accept="{{ $accept }}" multiple
                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                            <div
                                                class="glass-light p-8 rounded-3xl border-2 border-dashed border-slate-200 group-hover:border-primary-300 group-hover:bg-primary-50/10 transition-all text-center">
                                                <p class="text-sm font-black text-slate-900 leading-none">Ajouter d'autres
                                                    fichiers</p>
                                                <p
                                                    class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">
                                                    Images & Vidéos autorisées</p>
                                            </div>
                                        </div>
                                        @error('media') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="border-slate-100">

                            <!-- Section: Contact -->
                            <div class="space-y-8">
                                <div class="flex items-center space-x-4 mb-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold text-xs">
                                        3</div>
                                    <h2 class="text-xl font-display font-black text-slate-900">Contact</h2>
                                </div>

                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="location"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Lieu
                                            / Campus</label>
                                        <input type="text" id="location" name="location" required
                                            value="{{ old('location', $announcement->location) }}"
                                            class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-bold transition-all"
                                            placeholder="Ex: Campus Sanar, Saint-Louis">
                                        @error('location') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="phone"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">WhatsApp
                                            / Téléphone</label>
                                        <input type="tel" id="phone" name="phone" required
                                            value="{{ old('phone', $announcement->phone) }}"
                                            class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-bold transition-all">
                                        @error('phone') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col md:flex-row gap-4 pt-6">
                                <x-button type="submit" variant="primary" size="lg"
                                    class="flex-1 shadow-2xl shadow-primary-500/30">Mettre à jour l'annonce</x-button>
                                <x-button href="{{ route('dashboard.announcements') }}" variant="secondary" size="lg"
                                    class="md:w-48 bg-white">Annuler</x-button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-slate-200/50"
                        data-aos="fade-left">
                        <h4 class="text-lg font-display font-black text-slate-900 mb-2">Statut de l'annonce</h4>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed mb-6">Votre annonce est actuellement
                            {{ $announcement->status }}. Les modifications peuvent nécessiter une nouvelle validation.</p>
                        <x-button href="{{ route('announcements.show', $announcement) }}" variant="secondary" size="sm"
                            class="w-full">Voir l'annonce actuelle</x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection