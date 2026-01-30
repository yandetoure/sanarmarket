@extends('layouts.app')

@section('title', 'Créer un article - ' . $boutique->name . ' - Sanar Market')

@section('content')
    <div class="bg-slate-50 min-h-screen pb-20 pt-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-12 text-center" data-aos="fade-down">
                <h1 class="text-3xl md:text-5xl font-display font-black text-slate-900 leading-tight">
                    Nouvel <span class="text-gradient">Article</span>
                </h1>
                <p class="text-slate-500 font-medium mt-4 text-lg">Ajoutez une pépite à l'inventaire de <span
                        class="text-primary-600 font-black">{{ $boutique->name }}</span>.</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Form Column -->
                <div class="lg:col-span-2">
                    <div class="glass p-10 md:p-12 rounded-[3rem] border-white/60 shadow-2xl shadow-slate-200/50"
                        data-aos="fade-right">
                        <form method="POST" action="{{ route('boutiques.articles.store', $boutique) }}"
                            enctype="multipart/form-data" class="space-y-10">
                            @csrf

                            <!-- Section: Caractéristiques -->
                            <div class="space-y-8">
                                <div class="flex items-center space-x-4 mb-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold text-xs">
                                        1</div>
                                    <h2 class="text-xl font-display font-black text-slate-900">Caractéristiques</h2>
                                </div>

                                <div class="space-y-6">
                                    <div>
                                        <label for="name"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Nom
                                            du produit *</label>
                                        <input type="text" id="name" name="name" required value="{{ old('name') }}"
                                            class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-black transition-all placeholder-slate-300 text-xl"
                                            placeholder="Ex: Sneakers Air Max 2024">
                                        @error('name') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="description"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Description
                                            détaillée</label>
                                        <textarea id="description" name="description" rows="5"
                                            class="w-full glass-light p-5 rounded-3xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-700 font-medium leading-relaxed transition-all placeholder-slate-300"
                                            placeholder="Précisez la taille, la couleur, la matière et tout ce qui rend cet article unique..."></textarea>
                                        @error('description') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}
                                        </p> @enderror
                                    </div>

                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="boutique_category_id"
                                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Catégorie
                                                d'inventaire</label>
                                            <select id="boutique_category_id" name="boutique_category_id"
                                                class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-bold appearance-none transition-all">
                                                <option value="">Sans catégorie</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('boutique_category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('boutique_category_id') <p class="mt-2 text-xs text-red-500 font-bold">
                                            {{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label for="status"
                                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Disponibilité</label>
                                            <select id="status" name="status"
                                                class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-bold appearance-none transition-all">
                                                <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>En attente (Brouillon)</option>
                                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                                    Directement en ligne</option>
                                            </select>
                                            @error('status') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}
                                            </p> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-slate-100">

                            <!-- Section: Commerce -->
                            <div class="space-y-8">
                                <div class="flex items-center space-x-4 mb-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold text-xs">
                                        2</div>
                                    <h2 class="text-xl font-display font-black text-slate-900">Prix & Stock</h2>
                                </div>

                                <div class="grid md:grid-cols-2 gap-8">
                                    <div>
                                        <label for="price"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Prix
                                            de vente (FCFA) *</label>
                                        <div class="relative">
                                            <input type="number" id="price" name="price" step="0.01" min="0" required
                                                value="{{ old('price') }}"
                                                class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-black transition-all">
                                            <span
                                                class="absolute right-5 top-1/2 -translate-y-1/2 font-black text-slate-300 text-xs text-xs">FCFA</span>
                                        </div>
                                        @error('price') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="stock"
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Unités
                                            disponibles *</label>
                                        <input type="number" id="stock" name="stock" min="0" required
                                            value="{{ old('stock', 0) }}"
                                            class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-black transition-all">
                                        @error('stock') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="border-slate-100">

                            <!-- Section: Visuel -->
                            <div class="space-y-8">
                                <div class="flex items-center space-x-4 mb-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold text-xs">
                                        3</div>
                                    <h2 class="text-xl font-display font-black text-slate-900">Visuel Produit</h2>
                                </div>

                                <div>
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-4">Photo
                                        de l'article</label>
                                    <div class="relative group">
                                        <input type="file" name="image" id="image" accept="image/*"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <div
                                            class="glass-light p-10 rounded-3xl border-2 border-dashed border-slate-200 group-hover:border-primary-300 group-hover:bg-primary-50/10 transition-all text-center">
                                            <div
                                                class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 group-hover:bg-primary-100 transition-all text-slate-400 group-hover:text-primary-600">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <p class="text-sm font-black text-slate-900">Cliquez pour ajouter une photo</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">
                                                JPEG, PNG autorisés (2Mo max)</p>
                                        </div>
                                    </div>
                                    @error('image') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex flex-col md:flex-row gap-4 pt-6">
                                <x-button type="submit" variant="primary" size="lg"
                                    class="flex-1 shadow-2xl shadow-primary-500/30">Lister l'article</x-button>
                                <x-button href="{{ route('boutiques.manage', $boutique) }}" variant="secondary" size="lg"
                                    class="md:w-48 bg-white">Annuler</x-button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <div class="sticky top-32 space-y-8">
                        <!-- Boutique Badge -->
                        <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-slate-200/50 text-center"
                            data-aos="fade-left">
                            <div
                                class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 font-display font-black text-xl mx-auto mb-4 border border-white">
                                {{ strtoupper(substr($boutique->name, 0, 1)) }}
                            </div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Destiné à</p>
                            <h4 class="text-base font-display font-black text-slate-900 mb-6">{{ $boutique->name }}</h4>
                            <div class="h-px bg-slate-100 w-10 mx-auto mb-6"></div>
                            <p class="text-[10px] font-bold text-slate-500 leading-relaxed italic">"Un bon visuel et une
                                description claire augmentent vos chances de vente de 60%."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection