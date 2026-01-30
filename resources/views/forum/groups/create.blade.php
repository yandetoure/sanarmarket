@extends('layouts.app')

@section('title', 'Créer un groupe - Forum')

@section('content')
<section class="bg-white border-b">
    <div class="container mx-auto px-4 py-10">
        <h1 class="text-3xl font-semibold text-slate-900">Créer un groupe de discussion</h1>
        <p class="mt-2 max-w-2xl text-muted-foreground">
            Rassemblez des étudiants autour d’un sujet et définissez vos propres règles pour cadrer les échanges.
        </p>
    </div>
</section>

<section class="py-10">
    <div class="container mx-auto px-4">
        <div class="mx-auto max-w-3xl rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <form action="{{ route('forum.groups.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold uppercase tracking-[0.24em] text-slate-600">
                        Nom du groupe
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           maxlength="120"
                           class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-base text-slate-900 shadow-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold uppercase tracking-[0.24em] text-slate-600">
                        Description
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="4"
                              class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-base text-slate-900 shadow-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200"
                              placeholder="Décrivez l’objectif du groupe">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="rules" class="block text-sm font-semibold uppercase tracking-[0.24em] text-slate-600">
                        Règles du groupe
                    </label>
                    <textarea id="rules"
                              name="rules"
                              rows="6"
                              class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-base text-slate-900 shadow-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200"
                              placeholder="Listez les règles que les membres doivent respecter">{{ old('rules') }}</textarea>
                    @error('rules')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="cover_image" class="block text-sm font-semibold uppercase tracking-[0.24em] text-slate-600">
                        Photo du groupe
                    </label>
                    <input type="file"
                           id="cover_image"
                           name="cover_image"
                           accept="image/*"
                           class="mt-2 w-full rounded-xl border border-dashed border-slate-300 px-4 py-3 text-sm text-slate-500 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200">
                    <p class="mt-1 text-xs text-slate-400">Formats conseillés : JPG ou PNG, 2&nbsp;Mo max.</p>
                    @error('cover_image')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox"
                           id="is_private"
                           name="is_private"
                           value="1"
                           {{ old('is_private') ? 'checked' : '' }}
                           class="h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-500">
                    <label for="is_private" class="text-sm text-slate-600">
                        Groupe privé (les membres doivent être approuvés manuellement)
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('forum.index') }}"
                       class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-5 py-2.5 text-sm font-semibold uppercase tracking-[0.24em] text-slate-600 transition hover:border-slate-300">
                        Annuler
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-full bg-gray-900 px-6 py-2.5 text-sm font-semibold uppercase tracking-[0.24em] text-white transition hover:bg-gray-700">
                        <i data-lucide="plus" class="h-4 w-4"></i>
                        Créer le groupe
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // S'assurer que les icônes Lucide sont initialisées après le chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
    
    // Réinitialiser les icônes après le chargement complet si la page est déjà chargée
    if (document.readyState !== 'loading') {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }
</script>
@endsection

