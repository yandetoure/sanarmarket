@extends('layouts.app')

@section('title', $group->name . ' - Forum')

@section('content')
@php
    use Illuminate\Support\Str;
    $activeTab = $activeTab ?? 'posts';
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
                        <a href="{{ route('forum.groups.show', ['group' => $group, 'tab' => 'posts']) }}" 
                           class="px-3 md:px-4 py-3 text-sm font-medium transition whitespace-nowrap flex-shrink-0 {{ $activeTab === 'posts' ? 'font-semibold border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                            Publications
                        </a>
                        <a href="{{ route('forum.groups.show', ['group' => $group, 'tab' => 'about']) }}" 
                           class="px-3 md:px-4 py-3 text-sm font-medium transition whitespace-nowrap flex-shrink-0 {{ $activeTab === 'about' ? 'font-semibold border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                            À propos
                        </a>
                        <a href="{{ route('forum.groups.show', ['group' => $group, 'tab' => 'members']) }}" 
                           class="px-3 md:px-4 py-3 text-sm font-medium transition whitespace-nowrap flex-shrink-0 {{ $activeTab === 'members' ? 'font-semibold border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                            Membres
                        </a>
                        @if($isOwner)
                            <a href="{{ route('forum.groups.show', ['group' => $group, 'tab' => 'settings']) }}" 
                               class="px-3 md:px-4 py-3 text-sm font-medium transition whitespace-nowrap flex-shrink-0 {{ $activeTab === 'settings' ? 'font-semibold border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                                Paramètres
                            </a>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container mx-auto px-4 py-4 md:py-6">
        <div class="max-w-4xl mx-auto">
            <!-- Onglet Publications -->
            @if($activeTab === 'posts')
                <div class="space-y-4">
                    @forelse($threads as $thread)
                        <article class="rounded-lg border border-gray-200 bg-white shadow-sm overflow-hidden" data-thread-id="{{ $thread->id }}" data-thread-slug="{{ $thread->slug }}">
                            <!-- En-tête du post -->
                            <div class="p-4 pb-3">
                                <div class="flex items-start gap-3">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 via-blue-600 to-purple-600 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                                        {{ strtoupper(substr($thread->user->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h3 class="font-semibold text-gray-900">{{ $thread->user->name }}</h3>
                                            @if($thread->is_pinned)
                                                <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-semibold text-amber-700">
                                                    <i data-lucide="pin" class="h-3 w-3"></i> Épinglé
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500 mt-0.5" data-thread-date="{{ $thread->created_at->diffForHumans() }}">{{ $thread->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Contenu du post -->
                            <div class="px-4 pb-3">
                                <a href="{{ route('forum.show', $thread) }}">
                                    <h4 class="text-base font-semibold text-gray-900 mb-2 hover:text-blue-600 transition line-clamp-2">{{ $thread->title }}</h4>
                                </a>
                                @php
                                    $fullBody = strip_tags($thread->body);
                                    $truncatedBody = Str::limit($fullBody, 200);
                                    $isTruncated = strlen($fullBody) > 200;
                                @endphp
                                <div class="thread-content-{{ $thread->id }}">
                                    <p class="text-sm text-gray-700 leading-relaxed line-clamp-4 thread-text mb-0" 
                                       data-thread-body-full="{{ htmlspecialchars($fullBody, ENT_QUOTES, 'UTF-8') }}"
                                       data-thread-body-truncated="{{ htmlspecialchars($truncatedBody, ENT_QUOTES, 'UTF-8') }}">
                                        {{ $truncatedBody }}
                                    </p>
                                    @if($isTruncated)
                                        <button onclick="toggleThreadContent({{ $thread->id }})" 
                                                class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors thread-toggle-btn mt-0.5" 
                                                data-expanded="false">
                                            Voir plus
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Image du post -->
                            @if($thread->cover_image)
                                <div class="w-full" data-thread-image="{{ asset('storage/' . $thread->cover_image) }}">
                                    <a href="{{ route('forum.show', $thread) }}">
                                        <img src="{{ asset('storage/' . $thread->cover_image) }}" alt="{{ $thread->title }}" class="w-full h-auto object-cover">
                                    </a>
                                </div>
                            @endif

                            <!-- Statistiques et actions -->
                            <div class="px-4 py-3 border-t border-gray-100">
                                <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                                    <div class="flex items-center gap-4">
                                        <span class="flex items-center gap-1" data-replies-count>
                                            <i data-lucide="messages-square" class="h-4 w-4"></i>
                                            {{ $thread->replies_count }} {{ $thread->replies_count > 1 ? 'réponses' : 'réponse' }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i data-lucide="eye" class="h-4 w-4"></i>
                                            {{ number_format($thread->views) }} vues
                                        </span>
                                    </div>
                                    <span class="text-xs text-gray-500">
                                        {{ optional($thread->last_activity_at ?? $thread->updated_at ?? $thread->created_at)->diffForHumans() }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-1 border-t border-gray-100 pt-2">
                                    <button onclick="openCommentsModal('{{ $thread->slug }}', '{{ addslashes($thread->title) }}', '{{ addslashes($thread->user->name) }}')" class="flex-1 flex items-center justify-center gap-2 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                                        <i data-lucide="message-circle" class="h-4 w-4"></i>
                                        Commenter
                                    </button>
                                    <a href="{{ route('forum.show', $thread) }}" class="flex-1 flex items-center justify-center gap-2 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                                        <i data-lucide="share-2" class="h-4 w-4"></i>
                                        Partager
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-10 text-center text-gray-500">
                            <i data-lucide="message-circle-off" class="mx-auto mb-4 h-10 w-10 text-gray-400"></i>
                            <p>Aucun sujet pour ce groupe pour l'instant.</p>
                        </div>
                    @endforelse
                </div>

                @if($activeTab === 'posts')
                    <div class="mt-8">
                        {{ $threads->appends(['tab' => 'posts'])->links() }}
                    </div>
                @endif
            @endif

            <!-- Onglet À propos -->
            @if($activeTab === 'about')
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">À propos</h2>
                    @if($group->description)
                        <p class="text-gray-700 leading-relaxed mb-4">{{ $group->description }}</p>
                    @else
                        <p class="text-gray-500 italic">Aucune description disponible pour ce groupe.</p>
                    @endif
                    @if($group->rules)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500 mb-2">Règles</h3>
                            <p class="text-gray-700 whitespace-pre-line">{{ $group->rules }}</p>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Onglet Membres -->
            @if($activeTab === 'members')
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Membres</h2>
                        <span class="text-sm text-gray-500 font-semibold">{{ $activeMembers->count() }} membres</span>
                    </div>
                    <div class="space-y-3">
                        @forelse($activeMembers as $membership)
                            <div class="flex items-center justify-between rounded-lg border border-gray-200 px-4 py-3 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                                        {{ strtoupper(substr($membership->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">{{ $membership->user->name }}</p>
                                        <p class="text-xs uppercase tracking-wide text-gray-400">{{ $membership->role }}</p>
                                    </div>
                                </div>
                                @if($membership->user_id === $group->owner_id)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 border border-blue-200">
                                        <i data-lucide="crown" class="h-3 w-3"></i>
                                        Propriétaire
                                    </span>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <i data-lucide="users" class="mx-auto mb-3 h-10 w-10 text-gray-400"></i>
                                <p>Aucun membre pour le moment.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif

            <!-- Onglet Paramètres (propriétaire uniquement) -->
            @if($activeTab === 'settings' && $isOwner)
                <div class="space-y-6">
                    <!-- Bouton d'édition -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 mb-2">Paramètres du groupe</h2>
                                <p class="text-sm text-gray-600">Gérez les paramètres, les règles et la photo de couverture de votre groupe.</p>
                            </div>
                            <a href="{{ route('forum.groups.edit', $group) }}"
                               class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700 shadow-sm">
                                <i data-lucide="settings" class="h-4 w-4"></i>
                                Modifier
                            </a>
                        </div>
                    </div>

                    <!-- Membres actifs (pour gestion) -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">Membres actifs</h2>
                            <span class="text-sm text-gray-500">{{ $activeMembers->count() }}</span>
                        </div>
                        <div class="space-y-3">
                            @forelse($activeMembers as $membership)
                                <div class="flex items-center justify-between rounded-lg border border-gray-200 px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                                            {{ strtoupper(substr($membership->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">{{ $membership->user->name }}</p>
                                            <p class="text-xs uppercase tracking-wide text-gray-400">{{ $membership->role }}</p>
                                        </div>
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
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 border border-blue-200">
                                            <i data-lucide="crown" class="h-3 w-3"></i>
                                            Propriétaire
                                        </span>
                                    @endif
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">Aucun membre actif.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Membres bannis -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">Membres bannis</h2>
                            <span class="text-sm text-gray-500">{{ $bannedMembers->count() }}</span>
                        </div>
                        <div class="space-y-3">
                            @forelse($bannedMembers as $membership)
                                <div class="flex items-center justify-between rounded-lg border border-gray-200 px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                                            {{ strtoupper(substr($membership->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">{{ $membership->user->name }}</p>
                                            <p class="text-xs uppercase tracking-wide text-red-400">Banni</p>
                                        </div>
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
        </div>
    </div>
</section>

<!-- Modal de commentaires -->
<div id="commentsModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-75 p-4">
    <div class="bg-white rounded-lg shadow-2xl max-w-2xl w-full h-[90vh] max-h-[90vh] flex flex-col" style="display: flex; flex-direction: column; height: 90vh; max-height: 90vh; overflow: hidden;">
        <!-- En-tête du modal -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 flex-shrink-0">
            <h2 class="text-lg font-semibold text-gray-900" id="modalThreadTitle">Publication</h2>
            <button onclick="closeCommentsModal()" class="text-gray-400 hover:text-gray-600 transition">
                <i data-lucide="x" class="h-6 w-6"></i>
            </button>
        </div>

        <!-- Zone scrollable : Contenu du post + Commentaires -->
        <div class="flex-1 overflow-y-auto overflow-x-hidden" id="modalScrollableContent" style="flex: 1 1 auto; min-height: 0; overflow-y: auto; overflow-x: hidden;">
            <!-- Contenu du post dans le modal -->
            <div class="border-b border-gray-200 bg-gray-50">
                <div class="p-4">
                    <div class="flex items-start gap-3">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm" id="modalThreadAuthorInitial">
                            A
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900" id="modalThreadAuthor">Auteur</p>
                            <p class="text-xs text-gray-500" id="modalThreadDate"></p>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-700" id="modalThreadBody"></p>
                </div>
                <!-- Image du post dans le modal -->
                <div id="modalThreadImageContainer" class="hidden mt-4">
                    <img id="modalThreadImage" src="" alt="" class="w-full h-auto object-cover max-h-96">
                </div>
            </div>

            <!-- Liste des commentaires -->
            <div class="p-4" id="commentsList">
                <div class="flex items-center justify-center py-8">
                    <div class="text-center">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                        <p class="mt-2 text-sm text-gray-500">Chargement des commentaires...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire de commentaire -->
        @auth
            <div class="p-4 border-t border-gray-200 bg-gray-50 flex-shrink-0">
                <form id="commentForm" onsubmit="submitComment(event)" class="flex items-start gap-3">
                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 flex items-end gap-2">
                        <div class="flex-1">
                            <textarea
                                id="commentBody"
                                name="body"
                                rows="2"
                                required
                                placeholder="Écrivez un commentaire..."
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 resize-none"
                            ></textarea>
                            <div class="flex items-center gap-2 mt-2">
                                <button type="button" class="text-gray-400 hover:text-gray-600 transition">
                                    <i data-lucide="image" class="h-5 w-5"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" class="text-gray-400 hover:text-gray-600 transition self-end mb-1">
                            <i data-lucide="smile" class="h-5 w-5"></i>
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition whitespace-nowrap self-end">
                            Publier
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="p-4 border-t border-gray-200 bg-gray-50 text-center flex-shrink-0">
                <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                    Connectez-vous pour commenter
                </a>
            </div>
        @endauth
    </div>
</div>

@section('scripts')
<script>
    // Initialiser les icônes Lucide
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    let currentThreadSlug = null;

    function openCommentsModal(threadSlug, threadTitle, threadAuthor) {
        // Vérifier que le thread existe dans le DOM
        const threadElement = document.querySelector(`[data-thread-slug="${threadSlug}"]`);
        if (!threadElement) {
            alert('Cette publication n\'existe plus ou a été supprimée.');
            return;
        }
        
        currentThreadSlug = threadSlug;
        document.getElementById('modalThreadTitle').textContent = 'Publication de ' + threadAuthor;
        document.getElementById('modalThreadAuthor').textContent = threadAuthor;
        document.getElementById('modalThreadAuthorInitial').textContent = threadAuthor.charAt(0).toUpperCase();
        
        // Récupérer les données du thread depuis le DOM
        const threadBodyElement = threadElement.querySelector('.thread-text');
        const threadBody = threadBodyElement ? (threadBodyElement.getAttribute('data-thread-body-full') || threadBodyElement.textContent) : '';
        const threadDate = threadElement.querySelector('[data-thread-date]')?.textContent || '';
        document.getElementById('modalThreadBody').textContent = threadBody;
        document.getElementById('modalThreadDate').textContent = threadDate;
        
        // Récupérer l'image si elle existe
        const imageContainer = threadElement.querySelector('[data-thread-image]');
        const imageContainerModal = document.getElementById('modalThreadImageContainer');
        const imageModal = document.getElementById('modalThreadImage');
        
        if (imageContainer && imageContainer.getAttribute('data-thread-image')) {
            const imageUrl = imageContainer.getAttribute('data-thread-image');
            imageModal.src = imageUrl;
            imageModal.alt = threadTitle;
            imageContainerModal.classList.remove('hidden');
        } else {
            imageContainerModal.classList.add('hidden');
        }
        
        document.getElementById('commentsModal').classList.remove('hidden');
        document.getElementById('commentsModal').classList.add('flex');
        document.body.style.overflow = 'hidden';
        
        loadComments(threadSlug);
    }

    function closeCommentsModal() {
        document.getElementById('commentsModal').classList.add('hidden');
        document.getElementById('commentsModal').classList.remove('flex');
        document.body.style.overflow = '';
        currentThreadSlug = null;
        document.getElementById('commentBody').value = '';
        // Cacher l'image du modal
        document.getElementById('modalThreadImageContainer').classList.add('hidden');
    }

    function loadComments(threadSlug) {
        const commentsList = document.getElementById('commentsList');
        commentsList.innerHTML = `
            <div class="flex items-center justify-center py-8">
                <div class="text-center">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    <p class="mt-2 text-sm text-gray-500">Chargement des commentaires...</p>
                </div>
            </div>
        `;
        
        fetch(`/forum/${threadSlug}/replies`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => {
            if (!response.ok) {
                if (response.status === 404) {
                    throw new Error('Cette publication n\'existe plus ou a été supprimée.');
                }
                return response.json().then(data => {
                    throw new Error(data.message || 'Erreur lors du chargement des commentaires.');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.replies && data.replies.length > 0) {
                commentsList.innerHTML = data.replies.map(reply => `
                    <div class="flex items-start gap-3 mb-5">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 via-blue-600 to-purple-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-lg shadow-blue-500/30">
                            ${reply.user.initial}
                        </div>
                        <div class="flex-1">
                            <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-200">
                                <p class="font-bold text-sm text-gray-900 mb-1">${escapeHtml(reply.user.name)}</p>
                                <p class="text-sm text-gray-700 leading-relaxed">${escapeHtml(reply.body)}</p>
                            </div>
                            <div class="flex items-center gap-4 mt-2 text-xs text-gray-400">
                                <button class="hover:text-blue-600 transition-colors font-medium">J'aime</button>
                                <button class="hover:text-blue-600 transition-colors font-medium">Répondre</button>
                                <span class="text-gray-400">${reply.created_at}</span>
                            </div>
                        </div>
                    </div>
                `).join('');
            } else {
                commentsList.innerHTML = `
                    <div class="text-center py-12 text-gray-400">
                        <i data-lucide="message-circle" class="h-16 w-16 mx-auto mb-3 text-gray-300"></i>
                        <p class="text-sm font-semibold text-gray-500">Aucun commentaire pour le moment.</p>
                        <p class="text-xs mt-1 text-gray-400">Soyez le premier à commenter !</p>
                    </div>
                `;
            }
            
            // Réinitialiser les icônes Lucide
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        })
        .catch(error => {
            console.error('Erreur lors du chargement des commentaires:', error);
            commentsList.innerHTML = `
                <div class="text-center py-12 text-red-500">
                    <i data-lucide="alert-circle" class="h-16 w-16 mx-auto mb-3 text-red-300"></i>
                    <p class="text-sm font-bold text-red-600 mb-2">${escapeHtml(error.message || 'Erreur lors du chargement des commentaires.')}</p>
                    <button onclick="closeCommentsModal()" class="mt-3 px-4 py-2 text-xs font-semibold text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors">
                        Fermer
                    </button>
                </div>
            `;
            // Réinitialiser les icônes Lucide
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    }

    function submitComment(event) {
        event.preventDefault();
        
        if (!currentThreadSlug) return;
        
        const form = event.target;
        const formData = new FormData(form);
        const body = formData.get('body');
        
        if (!body || body.trim().length < 5) {
            alert('Le commentaire doit contenir au moins 5 caractères.');
            return;
        }
        
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.textContent = 'Publication...';
        
        fetch(`/forum/${currentThreadSlug}/reply`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                if (response.status === 404) {
                    throw new Error('Cette publication n\'existe plus ou a été supprimée.');
                }
                return response.json().then(data => {
                    throw new Error(data.message || 'Erreur lors de la publication du commentaire.');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                form.reset();
                loadComments(currentThreadSlug);
                
                // Mettre à jour le compteur de réponses sur la page
                const threadElement = document.querySelector(`[data-thread-slug="${currentThreadSlug}"]`);
                if (threadElement && data.thread) {
                    const repliesCountElement = threadElement.querySelector('[data-replies-count]');
                    if (repliesCountElement) {
                        const count = data.thread.replies_count;
                        const text = count > 1 ? 'réponses' : 'réponse';
                        repliesCountElement.innerHTML = `<i data-lucide="messages-square" class="h-4 w-4"></i> ${count} ${text}`;
                        // Réinitialiser les icônes Lucide
                        if (typeof lucide !== 'undefined') {
                            lucide.createIcons();
                        }
                    }
                }
            } else {
                alert(data.message || 'Erreur lors de la publication du commentaire.');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert(error.message || 'Erreur lors de la publication du commentaire.');
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.textContent = originalText;
        });
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Fermer le modal en cliquant sur le fond
    document.getElementById('commentsModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeCommentsModal();
        }
    });

    // Fermer avec la touche Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCommentsModal();
        }
    });

    // Fonction pour afficher/masquer le contenu complet d'une publication
    function toggleThreadContent(threadId) {
        const contentDiv = document.querySelector(`.thread-content-${threadId}`);
        const textElement = contentDiv.querySelector('.thread-text');
        const toggleBtn = contentDiv.querySelector('.thread-toggle-btn');
        if (!textElement || !toggleBtn) return;
        
        const isExpanded = toggleBtn.getAttribute('data-expanded') === 'true';
        const fullText = textElement.getAttribute('data-thread-body-full');
        const truncatedText = textElement.getAttribute('data-thread-body-truncated');
        
        if (isExpanded) {
            // Réduire le texte
            textElement.textContent = truncatedText;
            textElement.classList.add('line-clamp-4');
            toggleBtn.textContent = 'Voir plus';
            toggleBtn.setAttribute('data-expanded', 'false');
        } else {
            // Afficher le texte complet
            textElement.textContent = fullText;
            textElement.classList.remove('line-clamp-4');
            toggleBtn.textContent = 'Voir moins';
            toggleBtn.setAttribute('data-expanded', 'true');
        }
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
@endsection
