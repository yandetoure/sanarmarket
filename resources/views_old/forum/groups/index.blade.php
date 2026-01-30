@extends('layouts.app')

@section('title', 'Groupes - Forum')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp

<section class="bg-gray-100 min-h-screen">
    <!-- En-tête -->
    <div class="bg-white border-b border-gray-200 shadow-sm">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Groupes du Forum</h1>
                    <p class="text-gray-600">
                        Découvrez et rejoignez les communautés qui vous intéressent pour échanger avec d'autres étudiants.
                    </p>
                </div>
                @auth
                    <a href="{{ route('forum.groups.create') }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700 shadow-sm">
                        <i data-lucide="users-plus" class="h-4 w-4"></i>
                        Créer un groupe
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Liste des groupes -->
    <div class="container mx-auto px-4 py-8">
        @if($groups->count() > 0)
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($groups as $group)
                    @php
                        $isMember = in_array($group->id, $userGroupIds ?? []);
                        $isBanned = in_array($group->id, $bannedGroupIds ?? []);
                    @endphp
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300">
                        <!-- Image de couverture -->
                        @if($group->cover_image)
                            <a href="{{ route('forum.groups.show', $group) }}" class="block">
                                <div class="w-full h-32 overflow-hidden bg-gradient-to-br from-blue-500 via-purple-600 to-pink-500">
                                    <img src="{{ asset('storage/' . $group->cover_image) }}" 
                                         alt="{{ $group->name }}" 
                                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                </div>
                            </a>
                        @else
                            <a href="{{ route('forum.groups.show', $group) }}" class="block">
                                <div class="w-full h-32 bg-gradient-to-br from-blue-500 via-purple-600 to-pink-500 flex items-center justify-center">
                                    <span class="text-white text-2xl font-bold">{{ strtoupper(substr($group->name, 0, 1)) }}</span>
                                </div>
                            </a>
                        @endif
                        
                        <!-- Contenu du groupe -->
                        <div class="p-5">
                            <a href="{{ route('forum.groups.show', $group) }}" class="block">
                                <h2 class="text-xl font-bold text-gray-900 mb-2 hover:text-blue-600 transition-colors">{{ $group->name }}</h2>
                            </a>
                            
                            @if($group->description)
                                <p class="text-sm text-gray-600 line-clamp-2 mb-4 leading-relaxed">{{ $group->description }}</p>
                            @endif
                            
                            <!-- Statistiques -->
                            <div class="flex items-center gap-4 text-xs text-gray-500 mb-4">
                                <span class="flex items-center gap-1">
                                    <i data-lucide="users" class="h-3 w-3"></i>
                                    {{ number_format($group->members_count ?? 0) }} membres
                                </span>
                                <span class="flex items-center gap-1">
                                    <i data-lucide="message-circle" class="h-3 w-3"></i>
                                    {{ number_format($group->threads_count ?? 0) }} sujets
                                </span>
                            </div>
                            
                            <!-- Badge de statut -->
                            @auth
                                @if($isBanned)
                                    <div class="mb-4">
                                        <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 border border-red-200">
                                            <i data-lucide="shield-alert" class="h-3 w-3"></i>
                                            Vous êtes banni
                                        </span>
                                    </div>
                                @elseif($isMember)
                                    <div class="mb-4">
                                        <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700 border border-green-200">
                                            <i data-lucide="check-circle" class="h-3 w-3"></i>
                                            Membre
                                        </span>
                                    </div>
                                @endif
                            @endauth
                            
                            <!-- Actions -->
                            <div class="flex items-center justify-between gap-3 pt-4 border-t border-gray-100">
                                <a href="{{ route('forum.groups.show', $group) }}"
                                   class="flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                                    Voir le groupe
                                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                                </a>
                                
                                @auth
                                    @if($isBanned)
                                        <span class="text-xs text-red-600 font-medium">Accès refusé</span>
                                    @elseif(!$isMember)
                                        <form action="{{ route('forum.groups.join', $group) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 rounded-lg bg-blue-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-blue-700 shadow-sm">
                                                <i data-lucide="user-plus" class="h-3 w-3"></i>
                                                Rejoindre
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" 
                                       class="inline-flex items-center gap-1 rounded-lg border border-gray-300 px-4 py-2 text-xs font-semibold text-gray-700 transition hover:bg-gray-50">
                                        <i data-lucide="log-in" class="h-3 w-3"></i>
                                        Se connecter
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- État vide -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-12 text-center">
                <div class="max-w-md mx-auto">
                    <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="users" class="h-10 w-10 text-gray-400"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Aucun groupe pour le moment</h2>
                    <p class="text-gray-600 mb-6">
                        Soyez le premier à créer une communauté et rassemblez des étudiants autour d'un sujet qui vous passionne.
                    </p>
                    @auth
                        <a href="{{ route('forum.groups.create') }}"
                           class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700 shadow-sm">
                            <i data-lucide="users-plus" class="h-4 w-4"></i>
                            Créer le premier groupe
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700 shadow-sm">
                            <i data-lucide="log-in" class="h-4 w-4"></i>
                            Se connecter pour créer un groupe
                        </a>
                    @endauth
                </div>
            </div>
        @endif
    </div>
</section>

@section('scripts')
<script>
    // Initialiser les icônes Lucide
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
@endsection
@endsection
