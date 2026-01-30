@extends('layouts.app')

@section('title', 'Publier une annonce - Sanar Market')

@section('content')
    <div class="bg-slate-50 min-h-screen pb-20 pt-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-12 text-center" data-aos="fade-down">
                <h1 class="text-3xl md:text-5xl font-display font-black text-slate-900 leading-tight">
                    Vendez ce que vous <span class="text-gradient">ne portez plus</span>
                </h1>
                <p class="text-slate-500 font-medium mt-4 text-lg">Publiez votre annonce en moins de 2 minutes et touchez
                    des milliers d'étudiants.</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Form Column -->
                <div class="lg:col-span-2">
                    <div class="glass p-10 md:p-12 rounded-[3rem] border-white/60 shadow-2xl shadow-slate-200/50"
                        data-aos="fade-right">
                        <form method="POST" action="{{ route('announcements.store') }}" enctype="multipart/form-data"
                            class="space-y-10">
                            @csrf

                            <!-- Section: Infos de base -->
                            <div class="space-y-8">
                                <div class="flex items-center space-x-4 mb-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold text-xs">
                                        1</div>
                                    <h2 class="text-xl font-display font-black text-slate-900">L'essentiel</h2>
                                </div>

                                <div class="space-y-6">
                                    <div>
                                        <label for="title"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Titre
                                            de l'annonce</label>
                                        <input type="text" id="title" name="title" required value="{{ old('title') }}"
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
                                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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
                                                    value="{{ old('price') }}"
                                                    class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-black transition-all placeholder-slate-300"
                                                    placeholder="0">
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
                                    <h2 class="text-xl font-display font-black text-slate-900">Détails & Photos</h2>
                                </div>

                                <div class="space-y-6">
                                    <div>
                                        <label for="description"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Description</label>
                                        <textarea id="description" name="description" rows="5" required
                                            class="w-full glass-light p-5 rounded-3xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-700 font-medium leading-relaxed transition-all placeholder-slate-300"
                                            placeholder="Donnez envie aux acheteurs ! Détaillez l'état, les accessoires inclus, etc.">{{ old('description') }}</textarea>
                                        @error('description') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}
                                        </p> @enderror
                                    </div>

                                    <div>
                                        @php
                                            $limit = $mediaLimit ?? 3;
                                            $accept = ($canUploadVideo ?? false) ? 'image/*,video/*' : 'image/*';
                                        @endphp
                                        <label
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Médias
                                            ({{ $limit }} max)</label>
                                        <div class="relative group">
                                            <input type="file" name="media[]" id="media" accept="{{ $accept }}" multiple
                                                required
                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                            <div
                                                class="glass-light p-10 rounded-3xl border-2 border-dashed border-slate-200 group-hover:border-primary-300 group-hover:bg-primary-50/10 transition-all text-center">
                                                <div
                                                    class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 group-hover:bg-primary-100 group-hover:text-primary-600 transition-all">
                                                    <svg class="w-8 h-8 text-slate-400 group-hover:text-primary-600"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <p class="text-sm font-black text-slate-900">Cliquez ou glissez vos photos
                                                    ici</p>
                                                <p
                                                    class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">
                                                    {{ ($canUploadVideo ?? false) ? 'Images & Vidéos autorisées' : 'Images uniquement' }}
                                                </p>
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
                                            value="{{ old('location') }}"
                                            class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-bold transition-all placeholder-slate-300"
                                            placeholder="Ex: Campus Sanar, Saint-Louis">
                                        @error('location') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="phone"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">WhatsApp
                                            / Téléphone</label>
                                        <input type="tel" id="phone" name="phone" required value="{{ old('phone') }}"
                                            class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-bold transition-all placeholder-slate-300"
                                            placeholder="+221 77 000 00 00">
                                        @error('phone') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col md:flex-row gap-4 pt-6">
                                <x-button type="submit" variant="primary" size="lg"
                                    class="flex-1 shadow-2xl shadow-primary-500/30">Publier mon annonce</x-button>
                                <x-button href="{{ route('dashboard.announcements') }}" variant="secondary" size="lg"
                                    class="md:w-48 bg-white">Annuler</x-button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar Tips -->
                <div class="space-y-8">
                    <div class="sticky top-32 space-y-8">
                        <!-- Tip 1 -->
                        <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-slate-200/50"
                            data-aos="fade-left">
                            <div
                                class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500 mb-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-display font-black text-slate-900 mb-2">Conseil de vente</h4>
                            <p class="text-xs text-slate-500 font-medium leading-relaxed">Une annonce avec un prix réaliste
                                et au moins 3 photos de bonne qualité se vend 5x plus vite.</p>
                        </div>

                        <!-- Premium Promo -->
                        <div class="bg-primary-600 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-2xl shadow-primary-200"
                            data-aos="fade-left" data-aos-delay="100">
                            <div class="relative z-10">
                                <h4 class="text-xl font-display font-black leading-tight">Envie de booster votre annonce ?
                                </h4>
                                <p class="mt-4 text-primary-100 text-xs font-medium leading-relaxed">Découvrez nos options
                                    Premium pour placer votre annonce en tête de liste pendant 7 jours.</p>
                                <x-button variant="secondary" size="sm"
                                    class="mt-6 bg-white text-primary-600 border-none shadow-lg">En savoir plus</x-button>
                            </div>
                            <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        </div>

                        <!-- Guidelines -->
                        <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-slate-100/50"
                            data-aos="fade-left" data-aos-delay="200">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Règles</p>
                            <ul class="space-y-4">
                                <li class="flex items-start space-x-3">
                                    <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-xs font-bold text-slate-600">Articles conformes uniquement</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-xs font-bold text-slate-600">Pas de produits interdits</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-xs font-bold text-slate-600">Photos réelles obligatoires</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection