@extends('layouts.app')

@section('title', 'Nouveau sujet - Forum')

@section('content')
<section class="bg-white border-b">
    <div class="container mx-auto px-4 py-10">
        <h1 class="text-3xl font-semibold text-slate-900">Créer un nouveau sujet</h1>
        <p class="mt-2 max-w-2xl text-muted-foreground">
            Partagez une question, une opportunité ou une astuce avec la communauté des étudiants.
        </p>
    </div>
</section>

<section class="py-10">
    <div class="container mx-auto px-4">
        <div class="mx-auto max-w-3xl rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <form action="{{ route('forum.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf

                <div>
                    <label for="group_id" class="block text-sm font-semibold text-slate-700 uppercase tracking-[0.24em]">
                        Groupe
                    </label>
                    <select
                        id="group_id"
                        name="group_id"
                        required
                        class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-base text-slate-900 shadow-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200"
                    >
                        <option value="" disabled {{ old('group_id') ? '' : 'selected' }}>Sélectionnez un groupe</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" {{ (int) old('group_id') === $group->id ? 'selected' : '' }}>
                                {{ $group->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('group_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="title" class="block text-sm font-semibold text-slate-700 uppercase tracking-[0.24em]">
                        Titre du sujet
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        required
                        maxlength="150"
                        class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-base text-slate-900 shadow-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200"
                        placeholder="Ex : Bons plans logement proche du campus"
                    >
                    @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="cover_image" class="block text-sm font-semibold text-slate-700 uppercase tracking-[0.24em]">
                        Image du sujet (optionnel)
                    </label>
                    <input
                        type="file"
                        id="cover_image"
                        name="cover_image"
                        accept="image/*"
                        class="mt-2 w-full rounded-xl border border-dashed border-slate-300 px-4 py-3 text-sm text-slate-500 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200"
                    >
                    <p class="mt-1 text-xs text-slate-400">JPG ou PNG, 2&nbsp;Mo max.</p>
                    @error('cover_image')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="body" class="block text-sm font-semibold text-slate-700 uppercase tracking-[0.24em]">
                        Message
                    </label>
                    <textarea
                        id="body"
                        name="body"
                        rows="10"
                        required
                        class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-base text-slate-900 shadow-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200"
                        placeholder="Présentez votre sujet ou votre question..."
                    >{{ old('body') }}</textarea>
                    @error('body')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('forum.index') }}"
                       class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-5 py-2.5 text-sm font-semibold uppercase tracking-[0.24em] text-slate-600 transition hover:border-slate-300">
                        Annuler
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-6 py-2.5 text-sm font-semibold uppercase tracking-[0.24em] text-white transition hover:bg-slate-700">
                        <i data-lucide="send" class="h-4 w-4"></i>
                        Publier le sujet
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

