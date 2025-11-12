@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('title', 'Forum - Sanar Market')

@section('content')
<section class="bg-white border-b">
    <div class="container mx-auto px-4 py-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Forum communautaire</h1>
                <p class="mt-1 text-sm text-gray-600">
                    Parcourez les groupes et retrouvez les discussions partagées par les étudiants de Sanar Market.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                @auth
                    <a href="{{ route('forum.create') }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                        <i data-lucide="message-circle-plus" class="h-4 w-4"></i>
                        Nouveau sujet
                    </a>
                    <a href="{{ route('forum.groups.create') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                        <i data-lucide="users-plus" class="h-4 w-4"></i>
                        Créer un groupe
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                        <i data-lucide="lock" class="h-4 w-4"></i>
                        Connectez-vous pour participer
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>

<section class="bg-gray-100 py-6">
    <div class="container mx-auto px-4">
        <div class="flex gap-4">
            <!-- Sidebar Gauche - Groupes -->
            <aside class="hidden lg:block w-64 flex-shrink-0">
                <div class="sticky top-4 space-y-4">
                    <div class="rounded-lg border border-gray-200 bg-white p-4">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Groupes</p>
                        @auth
                                <a href="{{ route('forum.groups.create') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">+</a>
                        @endauth
                    </div>
                        <nav class="space-y-1">
                        <a href="{{ route('forum.index') }}"
                               class="flex items-center justify-between rounded-lg px-3 py-2 text-sm font-medium {{ $currentGroup ? 'text-gray-700 hover:bg-gray-100' : 'bg-blue-50 text-blue-700' }}">
                            <span class="inline-flex items-center gap-2"><i data-lucide="globe" class="h-4 w-4"></i>Général</span>
                                <span class="text-xs text-gray-500">{{ $groups->sum('threads_count') }}</span>
                        </a>
                            @foreach($groups->take(8) as $group)
                            @php
                                $isActive = $currentGroup && $currentGroup->id === $group->id;
                                $isMember = in_array($group->id, $userGroupIds ?? []);
                                $isBanned = in_array($group->id, $bannedGroupIds ?? []);
                            @endphp
                                <a href="{{ route('forum.index', ['group' => $group->slug]) }}" 
                                   class="flex items-center justify-between rounded-lg px-3 py-2 text-sm {{ $isActive ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <span class="truncate">{{ $group->name }}</span>
                                    <span class="text-xs text-gray-500 ml-2">{{ $group->threads_count }}</span>
                                </a>
                        @endforeach
                            @if($groups->count() > 8)
                                <a href="{{ route('forum.groups.index') }}" class="block text-center text-xs text-blue-600 hover:text-blue-700 font-medium py-2">
                                    Voir tous les groupes →
                                </a>
                            @endif
                    </nav>
                </div>
                    <div class="rounded-lg border border-gray-200 bg-white p-4 text-xs text-gray-600">
                        <p class="font-semibold uppercase tracking-wide text-gray-500 mb-2">Résumé</p>
                        <ul class="space-y-1">
                        <li><span class="font-semibold text-gray-800">{{ $groups->count() }}</span> groupes</li>
                        <li><span class="font-semibold text-gray-800">{{ number_format($threads->total()) }}</span> discussions</li>
                        <li><span class="font-semibold text-gray-800">{{ number_format($threads->sum('replies_count')) }}</span> réponses</li>
                    </ul>
                    </div>
                </div>
            </aside>

            <!-- Zone Centrale - Feed -->
            <div class="flex-1 max-w-2xl space-y-4">
                @if($currentGroup)
                    <div class="rounded-lg border border-gray-200 bg-white p-4">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1">Groupe sélectionné</p>
                                <h2 class="text-lg font-semibold text-gray-900">{{ $currentGroup->name }}</h2>
                                @if($currentGroup->description)
                                    <p class="mt-1 text-sm text-gray-600">{{ Str::limit($currentGroup->description, 100) }}</p>
                                @endif
                            </div>
                            <a href="{{ route('forum.groups.show', $currentGroup) }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                                Voir →
                            </a>
                        </div>
                                        </div>
                                    @endif

                @foreach($threads as $thread)
                    <article class="rounded-lg border border-gray-200 bg-white shadow-sm">
                        <!-- En-tête du post -->
                        <div class="p-4 pb-3">
                            <div class="flex items-start gap-3">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm">
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
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $thread->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Contenu du post -->
                        <div class="px-4 pb-3">
                            <a href="{{ route('forum.show', $thread) }}">
                                <h4 class="text-base font-semibold text-gray-900 mb-2 hover:text-blue-600 transition">{{ $thread->title }}</h4>
                            </a>
                            <p class="text-sm text-gray-700 leading-relaxed line-clamp-3">
                                {{ Str::limit(strip_tags($thread->body), 300) }}
                            </p>
                        </div>

                        <!-- Image du post -->
                        @if($thread->cover_image)
                            <div class="w-full">
                                <a href="{{ route('forum.show', $thread) }}">
                                    <img src="{{ asset('storage/' . $thread->cover_image) }}" alt="{{ $thread->title }}" class="w-full h-auto object-cover">
                                </a>
                            </div>
                        @endif

                        <!-- Statistiques et actions -->
                        <div class="px-4 py-3 border-t border-gray-100">
                            <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                                <div class="flex items-center gap-4">
                                    <span class="flex items-center gap-1">
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
                                <a href="{{ route('forum.show', $thread) }}" class="flex-1 flex items-center justify-center gap-2 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                                    <i data-lucide="message-circle" class="h-4 w-4"></i>
                                    Commenter
                                </a>
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
                <div class="sticky top-4 space-y-4">
                    @if($advertisements->count() > 0)
                        <div class="rounded-lg border border-gray-200 bg-white p-4">
                            <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-3">Sponsorisé</h3>
                            <div class="space-y-4">
                                @foreach($advertisements as $ad)
                                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition">
                                        @if($ad->image)
                                            <a href="{{ $ad->link ?? '#' }}" target="_blank" class="block">
                                                <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="w-full h-48 object-cover">
                                            </a>
                                        @endif
                                        <div class="p-3">
                                            <a href="{{ $ad->link ?? '#' }}" target="_blank" class="block">
                                                <h4 class="text-sm font-semibold text-gray-900 mb-1 hover:text-blue-600 transition">{{ $ad->title }}</h4>
                                            </a>
                                            @if(isset($ad->content) || isset($ad->description))
                                                <p class="text-xs text-gray-600 line-clamp-2 mb-2">{{ Str::limit($ad->content ?? $ad->description ?? '', 100) }}</p>
                                            @endif
                                            @if($ad->link)
                                                <a href="{{ $ad->link }}" target="_blank" class="text-xs text-blue-600 hover:text-blue-700 font-medium">
                                                    En savoir plus →
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Suggestions ou autres contenus -->
                    <div class="rounded-lg border border-gray-200 bg-white p-4">
                        <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-3">Suggestions</h3>
                        <div class="space-y-3 text-sm">
                            <a href="{{ route('forum.groups.index') }}" class="flex items-center gap-2 text-gray-700 hover:text-blue-600 transition">
                                <i data-lucide="users" class="h-4 w-4"></i>
                                Découvrir des groupes
                            </a>
                            <a href="{{ route('forum.create') }}" class="flex items-center gap-2 text-gray-700 hover:text-blue-600 transition">
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
@endsection
