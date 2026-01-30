@extends('layouts.app')

@section('title', 'Nouveau sujet - Forum')

@section('content')
    <div class="bg-slate-50 min-h-screen pb-20 pt-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-12 text-center" data-aos="fade-down">
                <h1 class="text-3xl md:text-5xl font-display font-black text-slate-900 leading-tight">
                    Lancez une <span class="text-gradient">Discussion</span>
                </h1>
                <p class="text-slate-500 font-medium mt-4 text-lg">Partagez vos idées, posez vos questions et échangez avec
                    la communauté.</p>
            </div>

            <div class="glass p-10 md:p-12 rounded-[3rem] border-white/60 shadow-2xl shadow-slate-200/50"
                data-aos="fade-up">
                <form action="{{ route('forum.store') }}" method="POST" class="space-y-10" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-8">
                        <div class="grid md:grid-cols-2 gap-8">
                            <div>
                                <label for="group_id"
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Groupe
                                    de destination *</label>
                                <select id="group_id" name="group_id" required
                                    class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-bold appearance-none transition-all">
                                    <option value="" disabled {{ old('group_id') ? '' : 'selected' }}>Sélectionnez un groupe
                                    </option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}" {{ (int) old('group_id') === $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                    @endforeach
                                </select>
                                @error('group_id') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="title"
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Titre
                                    du sujet *</label>
                                <input type="text" id="title" name="title" required value="{{ old('title') }}"
                                    maxlength="150"
                                    class="w-full glass-light p-5 rounded-2xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-900 font-bold transition-all placeholder-slate-300"
                                    placeholder="Ex: Conseils pour le stage de L3">
                                @error('title') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="body"
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Votre
                                message *</label>
                            <textarea id="body" name="body" rows="10" required
                                class="w-full glass-light p-5 rounded-3xl border-white/50 focus:border-primary-400 focus:ring-0 text-slate-700 font-medium leading-relaxed transition-all placeholder-slate-300"
                                placeholder="Développez votre idée ou posez votre question ici..."></textarea>
                            @error('body') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Image
                                de couverture (Optionnel)</label>
                            <div class="relative group">
                                <input type="file" name="cover_image" id="cover_image" accept="image/*"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div
                                    class="glass-light p-10 rounded-3xl border-2 border-dashed border-slate-200 group-hover:border-primary-300 group-hover:bg-primary-50/10 transition-all text-center">
                                    <div
                                        class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 group-hover:bg-primary-100 group-hover:text-primary-600 transition-all text-slate-400 group-hover:text-primary-600">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-black text-slate-900">Cliquez pour ajouter une image</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">Format
                                        JPEG, PNG autorisés (2Mo max)</p>
                                </div>
                            </div>
                            @error('cover_image') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row gap-4 pt-6">
                        <x-button type="submit" variant="primary" size="lg"
                            class="flex-1 shadow-2xl shadow-primary-500/30">Publier le sujet</x-button>
                        <x-button href="{{ route('forum.index') }}" variant="secondary" size="lg"
                            class="md:w-48 bg-white">Annuler</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection