@extends('layouts.app')

@section('title', 'À la une au campus - Sanar Market')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">À la une au campus</h1>
            <p class="text-muted-foreground">
                Informations importantes et actualités du campus
            </p>
        </div>
        @auth
            @if(auth()->user()->isAmbassador())
                <button onclick="document.getElementById('spotlight-form').classList.toggle('hidden')" 
                        class="bg-primary text-primary-foreground px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Ajouter une information
                </button>
            @endif
        @endauth
    </div>

    @auth
        @if(auth()->user()->isAmbassador())
            <form id="spotlight-form" action="{{ route('campus-spotlight.store') }}" method="POST" class="hidden mb-6 bg-white rounded-lg border border-slate-200 p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Titre *</label>
                        <input type="text" name="title" required class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Contenu *</label>
                        <textarea name="content" rows="4" required class="w-full px-4 py-2 border rounded-lg"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Type *</label>
                        <select name="type" required class="w-full px-4 py-2 border rounded-lg">
                            <option value="info">Information générale</option>
                            <option value="ag">Assemblée Générale</option>
                            <option value="opening">Ouverture campus</option>
                            <option value="other">Autre</option>
                        </select>
                    </div>
                    <div class="flex gap-4">
                        <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/90">
                            Publier
                        </button>
                        <button type="button" onclick="document.getElementById('spotlight-form').classList.add('hidden')" class="bg-slate-200 text-slate-700 px-6 py-2 rounded-lg hover:bg-slate-300">
                            Annuler
                        </button>
                    </div>
                </div>
            </form>
        @endif
    @endauth

    @if($spotlights->count() > 0)
        <div class="space-y-4">
            @foreach($spotlights as $spotlight)
                <div class="bg-white rounded-lg border border-slate-200 p-6 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-xl font-semibold text-slate-900">{{ $spotlight->title }}</h3>
                                <span class="text-xs px-2 py-1 rounded-full bg-primary/10 text-primary">
                                    {{ ucfirst($spotlight->type) }}
                                </span>
                            </div>
                            <p class="text-slate-600 mb-3 whitespace-pre-line">{{ $spotlight->content }}</p>
                            <p class="text-xs text-slate-400">
                                Publié {{ $spotlight->published_at->diffForHumans() }} par {{ $spotlight->user->name }}
                            </p>
                        </div>
                        @auth
                            @if(auth()->user()->isAmbassador())
                                <form action="{{ route('campus-spotlight.destroy', $spotlight) }}" method="POST" class="ml-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Êtes-vous sûr de vouloir désactiver cette information ?')">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <i data-lucide="megaphone" class="w-16 h-16 text-muted-foreground mx-auto mb-4"></i>
            <p class="text-muted-foreground text-lg">Aucune information disponible</p>
        </div>
    @endif
</div>

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection

