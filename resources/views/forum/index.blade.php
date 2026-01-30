@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('title', 'Forum - Sanar Market')

@section('content')
<section class="bg-gray-100 min-h-screen">
    <!-- En-tête simplifié intégré dans la sidebar -->
    <div class="bg-white border-b border-gray-200 sticky top-[4.5rem] z-30 shadow-sm h-16">
        <div class="container mx-auto px-4 h-full flex items-center">
            <div class="w-full flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <h1 class="text-xl font-bold text-gray-900">Forum</h1>
                    @if($currentGroup)
                        <span class="text-sm text-gray-500">•</span>
                        <span class="text-sm font-medium text-gray-700">{{ $currentGroup->name }}</span>
                    @endif
            </div>
                <div class="flex items-center gap-3">
                @auth
                    @if($currentGroup)
                        <a href="{{ route('forum.create') }}?group={{ $currentGroup->id }}"
                           class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                            <i data-lucide="message-circle-plus" class="h-4 w-4"></i>
                            <span class="hidden md:inline">Ouvrir un sujet</span>
                        </a>
                        <a href="{{ route('forum.groups.create') }}"
                               class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                            <i data-lucide="users-plus" class="h-4 w-4"></i>
                            <span class="hidden md:inline">Créer un groupe</span>
                        </a>
                    @else
                    <a href="{{ route('forum.create') }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                        <i data-lucide="message-circle-plus" class="h-4 w-4"></i>
                            <span class="hidden md:inline">Nouveau sujet</span>
                    </a>
                    <a href="{{ route('forum.groups.create') }}"
                               class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                        <i data-lucide="users-plus" class="h-4 w-4"></i>
                            <span class="hidden md:inline">Créer un groupe</span>
                    </a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                        <i data-lucide="lock" class="h-4 w-4"></i>
                            Connexion
                    </a>
                @endauth
                </div>
            </div>
        </div>
    </div>

<section class="bg-gray-100 pt-8 pb-4 relative">
    <div class="container mx-auto px-4">
        <div class="flex gap-4">
            <!-- Sidebar Gauche - Groupes -->
            <aside class="hidden lg:block w-64 flex-shrink-0">
                <div class="fixed top-[8.5rem] h-[calc(100vh-8.5rem)] overflow-y-auto pr-2 pb-4" style="left: max(1rem, calc((100vw - 1280px) / 2)); width: 16rem; z-index: 35;">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-5 m-2">
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                            <p class="text-sm font-bold text-gray-900">Groupes</p>
                        @auth
                                <a href="{{ route('forum.groups.create') }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-all shadow-md hover:shadow-lg text-sm font-bold">
                                    <i data-lucide="plus" class="h-4 w-4"></i>
                                </a>
                        @endauth
                    </div>
                        <nav class="space-y-1.5">
                        <a href="{{ route('forum.index') }}"
                               class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-medium transition-all {{ $currentGroup ? 'text-gray-700 hover:bg-gray-50' : 'bg-blue-50 text-blue-700 border-2 border-blue-200 shadow-sm' }}">
                                <span class="inline-flex items-center gap-2">
                                    <i data-lucide="globe" class="h-4 w-4"></i>
                                    <span class="font-semibold">Général</span>
                                </span>
                                <span class="text-[10px] text-gray-400 font-medium ml-2">{{ number_format($totalUsersCount ?? 0) }} mem</span>
                            </a>
                            @foreach($groups as $group)
                            @php
                                $isActive = $currentGroup && $currentGroup->id === $group->id;
                                $isMember = in_array($group->id, $userGroupIds ?? []);
                                $isBanned = in_array($group->id, $bannedGroupIds ?? []);
                            @endphp
                                <a href="{{ route('forum.index', ['group' => $group->slug]) }}" 
                                   class="flex items-center justify-between rounded-xl px-4 py-3 text-sm transition-all {{ $isActive ? 'bg-blue-50 text-blue-700 font-semibold border-2 border-blue-200 shadow-sm' : 'text-gray-700 hover:bg-gray-50 hover:shadow-sm border border-transparent hover:border-gray-200' }}">
                                    <span class="truncate font-medium">{{ $group->name }}</span>
                                    <span class="text-[10px] text-gray-400 font-medium ml-2">{{ $group->members_count ?? 0 }} mem</span>
                                </a>
                        @endforeach
                    </nav>
                    </div>
                </div>
            </aside>

            <!-- Zone Centrale - Feed -->
            <div class="flex-1 max-w-2xl space-y-4 mx-auto">
                @if($currentGroup)
                    <div class="rounded-lg border border-blue-200 bg-blue-50 p-4 shadow-sm">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-xs font-semibold uppercase tracking-wide text-blue-600 mb-1">Groupe sélectionné</p>
                                <h2 class="text-lg font-bold text-gray-900 mb-1">{{ $currentGroup->name }}</h2>
                                @if($currentGroup->description)
                                    <p class="text-sm text-gray-600 leading-relaxed">{{ Str::limit($currentGroup->description, 100) }}</p>
                                @endif
                            </div>
                            <a href="{{ route('forum.groups.show', $currentGroup) }}" class="ml-4 inline-flex items-center gap-1 text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                                Voir <i data-lucide="arrow-right" class="h-4 w-4"></i>
                            </a>
                        </div>
                                        </div>
                                    @endif

                @foreach($threads as $thread)
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
                                        @if($thread->group)
                                            <span class="text-xs text-gray-500">dans</span>
                                            <a href="{{ route('forum.index', ['group' => $thread->group->slug]) }}" class="text-xs font-medium text-blue-600 hover:text-blue-700">
                                                {{ $thread->group->name }}
                                            </a>
                                @endif
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
                @endforeach

                <!-- Pagination -->
                <div class="py-4">
                {{ $threads->links() }}
                </div>
            </div>

            <!-- Sidebar Droite - Publicités -->
            <aside class="hidden xl:block w-80 flex-shrink-0">
                <div class="fixed top-[8.5rem] h-[calc(100vh-8.5rem)] overflow-y-auto space-y-4 pr-4" style="right: max(1rem, calc((100vw - 1280px) / 2)); width: 20rem; z-index: 35;">
                    <div class="px-2 pt-4">
                        <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-3 px-2">Sponsorisé</h3>
                        <div class="space-y-4">
                            @if($advertisements->count() > 0)
                                @foreach($advertisements as $ad)
                                    <div class="border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 bg-white">
                                        @if($ad->image)
                                            <a href="{{ $ad->link ?? '#' }}" target="_blank" class="block overflow-hidden">
                                                <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300">
                                            </a>
                                        @endif
                                        <div class="p-4">
                                            <a href="{{ $ad->link ?? '#' }}" target="_blank" class="block">
                                                <h4 class="text-sm font-bold text-gray-900 mb-2 hover:text-blue-600 transition-colors leading-tight">{{ $ad->title }}</h4>
                                            </a>
                                            @if(isset($ad->content) || isset($ad->description))
                                                <p class="text-xs text-gray-600 line-clamp-2 mb-3 leading-relaxed">{{ Str::limit($ad->content ?? $ad->description ?? '', 100) }}</p>
                                            @endif
                                            @if($ad->link)
                                                <a href="{{ $ad->link }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-blue-600 hover:text-blue-700 font-semibold transition-colors">
                                                    En savoir plus <i data-lucide="arrow-right" class="h-3 w-3"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- Publicités fictives pour aperçu -->
                                @php
                                    $fakeAds = [
                                        [
                                            'title' => 'Formation en ligne - Business Management',
                                            'description' => 'Obtenez votre certificat en gestion d\'entreprise. Cours complet avec certification reconnue. 70% de réduction !',
                                            'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=400&h=300&fit=crop',
                                            'link' => '#'
                                        ],
                                        [
                                            'title' => 'Trouvez l\'amour et la connexion ! ❤️',
                                            'description' => 'Rejoignez notre communauté et rencontrez des personnes partageant vos intérêts. Inscription gratuite.',
                                            'image' => 'https://images.unsplash.com/photo-1522673607200-164d1b6ce486?w=400&h=300&fit=crop',
                                            'link' => '#'
                                        ],
                                        [
                                            'title' => 'Cours de développement web',
                                            'description' => 'Apprenez à créer des sites web modernes avec les dernières technologies. Démarrez votre carrière dès aujourd\'hui.',
                                            'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=400&h=300&fit=crop',
                                            'link' => '#'
                                        ]
                                    ];
                                @endphp
                                @foreach($fakeAds as $fakeAd)
                                    <div class="border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 bg-white">
                                        <a href="{{ $fakeAd['link'] }}" target="_blank" class="block overflow-hidden">
                                            <div class="w-full h-48 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                                <img src="{{ $fakeAd['image'] }}" alt="{{ $fakeAd['title'] }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                            </div>
                                        </a>
                                        <div class="p-4">
                                            <a href="{{ $fakeAd['link'] }}" target="_blank" class="block">
                                                <h4 class="text-sm font-bold text-gray-900 mb-2 hover:text-blue-600 transition-colors leading-tight">{{ $fakeAd['title'] }}</h4>
                                            </a>
                                            <p class="text-xs text-gray-600 line-clamp-2 mb-3 leading-relaxed">{{ $fakeAd['description'] }}</p>
                                            <a href="{{ $fakeAd['link'] }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-blue-600 hover:text-blue-700 font-semibold transition-colors">
                                                En savoir plus <i data-lucide="arrow-right" class="h-3 w-3"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Suggestions ou autres contenus -->
                    <div class="px-2 mt-4">
                        <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-3 px-2">Suggestions</h3>
                        <div class="space-y-1 text-sm">
                            <a href="{{ route('forum.groups.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover:text-blue-600 hover:bg-gray-100 transition-all font-medium">
                                <i data-lucide="users" class="h-4 w-4"></i>
                                Découvrir des groupes
                            </a>
                            <a href="{{ route('forum.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover:text-blue-600 hover:bg-gray-100 transition-all font-medium">
                                <i data-lucide="message-circle-plus" class="h-4 w-4"></i>
                                Créer un sujet
                            </a>
                        </div>
                    </div>
                </div>
            </aside>
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

<script>
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
    const threadBody = threadElement.querySelector('[data-thread-body]')?.textContent || '';
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
@endsection
