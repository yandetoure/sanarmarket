@extends('layouts.app')

@section('title', $group->name . ' - Forum')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp

<section class="bg-gray-100 min-h-screen">
    <!-- Photo de couverture -->
    <div class="relative w-full h-32 md:h-40 overflow-hidden bg-gradient-to-br from-blue-500 via-purple-600 to-pink-500">
                @if($group->cover_image)
            <img src="{{ asset('storage/' . $group->cover_image) }}" 
                 alt="{{ $group->name }}" 
                 class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <div class="text-white text-center px-4">
                    <h2 class="text-xl md:text-3xl font-bold mb-2">{{ $group->name }}</h2>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Informations du groupe -->
    <div class="bg-white border-x border-b border-gray-200 shadow-lg">
        <div class="container mx-auto px-4 pb-4">
            <div class="max-w-4xl mx-auto">
                <!-- Photo de profil et informations -->
                <div class="relative -mt-6 md:-mt-8 mb-4">
                <div class="flex items-end gap-3 md:gap-4">
                    <!-- Photo de profil ronde -->
                    <div class="relative inline-block">
                        <div class="h-20 w-20 md:h-32 md:w-32 rounded-full bg-gradient-to-br from-blue-600 to-purple-600 border-4 border-white shadow-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-white text-2xl md:text-4xl font-bold">{{ strtoupper(substr($group->name, 0, 1)) }}</span>
                        </div>
                    </div>
                    
                    <!-- Nom et stats -->
                    <div class="flex-1 pb-2 min-w-0">
                        <h1 class="text-xl md:text-3xl font-bold text-gray-900 mb-1 md:mb-2 truncate">{{ $group->name }}</h1>
                        <div class="flex items-center gap-2 md:gap-4 text-xs md:text-sm text-gray-600 flex-wrap">
                            <span class="font-semibold">{{ number_format($group->members_count ?? 0) }} membres</span>
                            <span class="hidden md:inline">•</span>
                            <span>{{ number_format($group->threads_count ?? 0) }} discussions</span>
                </div>
                    </div>
                </div>
            </div>
            
            <!-- Boutons d'action -->
            <div class="flex flex-wrap md:flex-nowrap items-center gap-2 md:gap-3 mb-4">
                @auth
                    @if($isOwner)
                        <a href="{{ route('forum.groups.edit', $group) }}"
                           class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 md:px-6 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                            <i data-lucide="settings" class="h-4 w-4"></i>
                            Configurer
                        </a>
                    @endif
                    @if($isBanned)
                        <span class="flex items-center justify-center gap-2 rounded-lg border border-red-500 px-4 md:px-6 py-2.5 text-sm font-semibold text-red-600">
                            <i data-lucide="shield-alert" class="h-4 w-4"></i>
                            Vous êtes banni
                        </span>
                    @elseif($isMember)
                        <a href="{{ route('forum.create') }}?group={{ $group->id }}"
                           class="flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 md:px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 shadow-sm">
                            <i data-lucide="message-circle-plus" class="h-4 w-4"></i>
                            Créer un sujet
                        </a>
                        <span class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 md:px-6 py-2.5 text-sm font-semibold text-gray-700">
                            <i data-lucide="check" class="h-4 w-4"></i>
                            Membre
                        </span>
                    @else
                        <form action="{{ route('forum.groups.join', $group) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 md:px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 shadow-sm">
                                <i data-lucide="user-plus" class="h-4 w-4"></i>
                                Rejoindre
                            </button>
                        </form>
                    @endif
                    <button class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                        <i data-lucide="bell" class="h-4 w-4"></i>
                        <span class="hidden md:inline">Notifications</span>
                    </button>
                    <button class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                        <i data-lucide="more-horizontal" class="h-4 w-4"></i>
                    </button>
                @else
                    <a href="{{ route('login') }}" 
                       class="flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 md:px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 shadow-sm">
                        <i data-lucide="log-in" class="h-4 w-4"></i>
                        Se connecter pour rejoindre
                    </a>
                @endauth
            </div>
            
            <!-- Onglets de navigation -->
            <div class="border-t border-gray-200 pt-0">
                <nav class="flex items-center gap-1 -mb-px overflow-x-auto scrollbar-hide">
                    <a href="{{ route('forum.groups.show', $group) }}" 
                       class="px-3 md:px-4 py-3 text-sm font-semibold border-b-2 border-blue-600 text-blue-600 transition whitespace-nowrap flex-shrink-0">
                        Publications
                    </a>
                    <a href="#about" 
                       class="px-3 md:px-4 py-3 text-sm font-medium text-gray-600 hover:text-gray-900 transition whitespace-nowrap flex-shrink-0">
                        À propos
                    </a>
                    <a href="#members" 
                       class="px-3 md:px-4 py-3 text-sm font-medium text-gray-600 hover:text-gray-900 transition whitespace-nowrap flex-shrink-0">
                        Membres
                    </a>
                    <a href="#photos" 
                       class="px-3 md:px-4 py-3 text-sm font-medium text-gray-600 hover:text-gray-900 transition whitespace-nowrap flex-shrink-0">
                        Photos
                    </a>
                </nav>
            </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container mx-auto px-4 py-4 md:py-6">
        <div class="max-w-4xl mx-auto">
            <!-- Section À propos -->
            @if($group->description || $group->rules)
                <div id="about" class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">À propos</h2>
                    @if($group->description)
                        <p class="text-gray-700 leading-relaxed mb-4">{{ $group->description }}</p>
                    @endif
                    @if($group->rules)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500 mb-2">Règles</h3>
                            <p class="text-gray-700 whitespace-pre-line">{{ $group->rules }}</p>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Section Membres (pour les propriétaires) -->
        @if($isOwner)
                <div id="members" class="mb-6 grid gap-6 lg:grid-cols-2">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">Membres actifs</h2>
                            <span class="text-sm text-gray-500">{{ $activeMembers->count() }}</span>
                    </div>
                        <div class="space-y-3">
                        @forelse($activeMembers as $membership)
                                <div class="flex items-center justify-between rounded-lg border border-gray-200 px-4 py-3">
                                <div>
                                        <p class="text-sm font-semibold text-gray-800">{{ $membership->user->name }}</p>
                                        <p class="text-xs uppercase tracking-wide text-gray-400">{{ $membership->role }}</p>
                                </div>
                                @if($membership->user_id !== $group->owner_id)
                                    <form action="{{ route('forum.groups.members.ban', [$group, $membership->user]) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                    class="inline-flex items-center gap-1 rounded-lg border border-red-500 px-3 py-1 text-xs font-semibold text-red-600 transition hover:bg-red-50">
                                            <i data-lucide="ban" class="h-3 w-3"></i>
                                            Bannir
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @empty
                                <p class="text-sm text-gray-500">Aucun membre actif.</p>
                        @endforelse
                    </div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">Membres bannis</h2>
                            <span class="text-sm text-gray-500">{{ $bannedMembers->count() }}</span>
                        </div>
                        <div class="space-y-3">
                        @forelse($bannedMembers as $membership)
                                <div class="flex items-center justify-between rounded-lg border border-gray-200 px-4 py-3">
                                <div>
                                        <p class="text-sm font-semibold text-gray-800">{{ $membership->user->name }}</p>
                                        <p class="text-xs uppercase tracking-wide text-gray-400">Banni</p>
                                </div>
                                <form action="{{ route('forum.groups.members.unban', [$group, $membership->user]) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                                class="inline-flex items-center gap-1 rounded-lg border border-emerald-500 px-3 py-1 text-xs font-semibold text-emerald-600 transition hover:bg-emerald-50">
                                        <i data-lucide="rotate-ccw" class="h-3 w-3"></i>
                                        Réintégrer
                                    </button>
                                </form>
                            </div>
                        @empty
                                <p class="text-sm text-gray-500">Aucun membre banni.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif

            <!-- Liste des sujets -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="hidden bg-gray-50 px-6 py-3 text-sm font-semibold uppercase tracking-wide text-gray-500 sm:grid sm:grid-cols-6 border-b border-gray-200">
                <span class="col-span-3">Sujet</span>
                    <span class="col-span-1 text-center">Réponses</span>
                    <span class="col-span-1 text-center">Vues</span>
                    <span class="col-span-1 text-right">Activité</span>
            </div>

                <div class="divide-y divide-gray-200">
                @forelse($threads as $thread)
                    <a href="{{ route('forum.show', $thread) }}"
                           class="flex flex-col gap-4 px-6 py-5 transition hover:bg-gray-50 sm:grid sm:grid-cols-6 sm:items-center">
                        <div class="col-span-3">
                                <div class="flex items-center gap-2 text-xs uppercase tracking-wide text-gray-400">
                                <span>{{ $thread->user->name }}</span>
                                    <span class="mx-1 text-gray-300">•</span>
                                <span>{{ $thread->created_at->diffForHumans() }}</span>
                                @if($thread->is_pinned)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2 py-0.5 text-[11px] font-semibold text-amber-700">
                                        <i data-lucide="pin" class="h-3 w-3"></i> Épinglé
                                    </span>
                                @endif
                            </div>
                                <h2 class="mt-2 text-xl font-semibold text-gray-900">{{ $thread->title }}</h2>
                                <p class="mt-2 line-clamp-2 text-sm text-gray-500">
                                {{ Str::limit(strip_tags($thread->body), 200) }}
                            </p>
                        </div>
                            <div class="col-span-1 text-sm font-semibold text-gray-700 sm:text-center">
                            {{ $thread->replies_count }}
                        </div>
                            <div class="col-span-1 text-sm font-semibold text-gray-700 sm:text-center">
                            {{ number_format($thread->views) }}
                        </div>
                            <div class="col-span-1 text-sm text-gray-500 sm:text-right">
                            {{ optional($thread->last_activity_at ?? $thread->updated_at ?? $thread->created_at)->diffForHumans() }}
                        </div>
                    </a>
                @empty
                        <div class="px-6 py-10 text-center text-gray-500">
                            <i data-lucide="message-circle-off" class="mx-auto mb-4 h-10 w-10 text-gray-400"></i>
                            <p>Aucun sujet pour ce groupe pour l'instant.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-8">
            {{ $threads->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script>
    // Initialiser les icônes Lucide
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>

<style>
    /* Masquer la scrollbar mais garder la fonctionnalité de scroll */
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
</style>
@endsection
