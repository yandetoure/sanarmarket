@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('title', 'Forum - Sanar Market')

@section('content')
<section class="bg-white border-b">
    <div class="container mx-auto px-4 py-10">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900">Forum communautaire</h1>
                <p class="mt-2 max-way-2xl text-sm text-gray-700">
                    Parcourez les groupes et retrouvez les discussions partagées par les étudiants de Sanar Market.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                @auth
                    <a href="{{ route('forum.create') }}"
                       class="inline-flex items-center gap-2 rounded-full border border-gray-900 px-5 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-gray-900 transition hover:bg-gray-900 hover:text-white">
                        <i data-lucide="message-circle-plus" class="h-4 w-4"></i>
                        Nouveau sujet
                    </a>
                    <a href="{{ route('forum.groups.create') }}"
                       class="inline-flex items-center gap-2 rounded-full border border-gray-300 px-5 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-gray-800 transition hover:border-gray-400 hover:text-gray-900">
                        <i data-lucide="users-plus" class="h-4 w-4"></i>
                        Créer un groupe
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 rounded-full border border-gray-300 px-5 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-gray-800 transition hover:border-gray-400 hover:text-gray-900">
                        <i data-lucide="lock" class="h-4 w-4"></i>
                        Connectez-vous pour participer
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>

<section class="bg-gray-50 py-10">
    <div class="container mx-auto px-4">
        <div class="flex flex-col gap-6 lg:flex-row">
            <aside class="lg:w-[30%] space-y-6">
                <div class="rounded-2xl border border-gray-200 bg-white p-4">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-gray-500">Groupes</p>
                        @auth
                            <a href="{{ route('forum.groups.create') }}" class="text-[11px] font-semibold uppercase tracking-[0.24em] text-gray-700 hover:text-gray-900">+
                            </a>
                        @endauth
                    </div>
                    <nav class="mt-4 space-y-1">
                        <a href="{{ route('forum.index') }}"
                           class="flex items-center justify-between rounded-xl px-3 py-2 text-sm font-semibold {{ $currentGroup ? 'text-gray-600 hover:bg-gray-100' : 'bg-gray-900 text-white' }}">
                            <span class="inline-flex items-center gap-2"><i data-lucide="globe" class="h-4 w-4"></i>Général</span>
                            <span class="text-xs">{{ $groups->sum('threads_count') }}</span>
                        </a>
                        @foreach($groups as $group)
                            @php
                                $isActive = $currentGroup && $currentGroup->id === $group->id;
                                $isMember = in_array($group->id, $userGroupIds ?? []);
                                $isBanned = in_array($group->id, $bannedGroupIds ?? []);
                            @endphp
                            <div class="rounded-xl border {{ $isActive ? 'border-gray-900 bg-white text-gray-900 shadow-sm' : 'border-gray-200 bg-white text-gray-700' }}">
                                <a href="{{ route('forum.index', ['group' => $group->slug]) }}" class="block px-3 py-2">
                                    <p class="text-sm font-semibold">{{ $group->name }}</p>
                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <span>{{ $group->threads_count }} sujet(s)</span>
                                        @if($isBanned)
                                            <span class="text-red-500">Banni</span>
                                        @elseif($isMember)
                                            <span class="text-emerald-600">Membre</span>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </nav>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-4 text-xs text-gray-600">
                    <p class="font-semibold uppercase tracking-[0.28em] text-gray-500">Résumé</p>
                    <ul class="mt-3 space-y-1">
                        <li><span class="font-semibold text-gray-800">{{ $groups->count() }}</span> groupes</li>
                        <li><span class="font-semibold text-gray-800">{{ number_format($threads->total()) }}</span> discussions</li>
                        <li><span class="font-semibold text-gray-800">{{ number_format($threads->sum('replies_count')) }}</span> réponses</li>
                    </ul>
                </div>
            </aside>

            <div class="lg:w-[70%] space-y-4">
                @php
                    $latestThread = null;
                @endphp
                @if($currentGroup)
                    @php
                        $latestThread = $threads->first();
                    @endphp
                    <div class="rounded-2xl border border-gray-200 bg-white p-5">
                        <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                            <div class="space-y-2">
                                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-gray-500">Groupe sélectionné</p>
                                <h2 class="text-xl font-semibold text-gray-900">{{ $currentGroup->name }}</h2>
                                @if($currentGroup->description)
                                    <p class="text-sm text-gray-700">{{ $currentGroup->description }}</p>
                                @endif
                                @if($currentGroup->rules)
                                    <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700">
                                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-gray-500">Règles</p>
                                        <p class="mt-2 whitespace-pre-line">{{ $currentGroup->rules }}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="flex flex-col items-end gap-2 text-sm text-gray-600">
                                <span>{{ $currentGroup->threads_count ?? $currentGroup->threads()->count() }} sujet(s)</span>
                                <a href="{{ route('forum.groups.show', $currentGroup) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-900 hover:text-gray-700">
                                    Voir le groupe
                                    <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @if($latestThread)
                        <div class="rounded-2xl border border-gray-200 bg-white p-5">
                            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                                <div class="flex items-start gap-4">
                                    @if($latestThread->cover_image)
                                        <div class="h-20 w-20 overflow-hidden rounded-xl border border-gray-200">
                                            <img src="{{ asset('storage/' . $latestThread->cover_image) }}" alt="{{ $latestThread->title }}" class="w-full h-full object-cover">
                                        </div>
                                    @endif
                                    <div class="space-y-3">
                                        <div class="flex flex-wrap items-center gap-2 text-xs uppercase tracking-[0.28em] text-gray-500">
                                            <span>{{ $latestThread->user->name }}</span>
                                            <span class="mx-1 text-gray-300">•</span>
                                            <span>{{ $latestThread->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $latestThread->title }}</h3>
                                            <p class="mt-1 text-sm text-gray-700">
                                                {{ Str::limit(strip_tags($latestThread->body), 200) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex shrink-0 items-center gap-3 text-sm text-gray-600">
                                    <div class="flex items-center gap-1.5 rounded-full border border-gray-200 px-3 py-1 font-semibold text-gray-700">
                                        <i data-lucide="messages-square" class="h-4 w-4"></i>
                                        {{ $latestThread->replies_count }}
                                    </div>
                                    <div class="flex items-center gap-1.5 rounded-full border border-gray-200 px-3 py-1 font-semibold text-gray-700">
                                        <i data-lucide="eye" class="h-4 w-4"></i>
                                        {{ number_format($latestThread->views) }}
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center justify-between border-t border-gray-200 pt-4 text-xs uppercase tracking-[0.28em] text-gray-500">
                                <span>Activité {{ optional($latestThread->last_activity_at ?? $latestThread->updated_at ?? $latestThread->created_at)->diffForHumans() }}</span>
                                <a href="{{ route('forum.show', $latestThread) }}" class="inline-flex items-center gap-2 text-xs font-semibold text-gray-900 hover:text-gray-700">
                                    Voir les détails
                                    <i data-lucide="arrow-up-right" class="h-3 w-3"></i>
                                </a>
                            </div>
                        </div>
                    @endif
                @endif

                @foreach($threads as $index => $thread)
                    @php if($index === 0 && $latestThread && $thread->id === $latestThread->id) { continue; } @endphp
                    <article class="rounded-2xl border border-gray-200 bg-white p-5">
                        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                            <div class="flex items-start gap-4">
                                @if($thread->cover_image)
                                    <div class="h-20 w-20 overflow-hidden rounded-xl border border-gray-200">
                                        <img src="{{ asset('storage/' . $thread->cover_image) }}" alt="{{ $thread->title }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                                <div class="space-y-3">
                                    <div class="flex flex-wrap items-center gap-2 text-xs uppercase tracking-[0.28em] text-gray-500">
                                        <span class="inline-flex items-center gap-1 rounded-full border border-gray-300 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.3em] text-gray-700">
                                            {{ optional($thread->group)->name ?? 'Groupe inconnu' }}
                                        </span>
                                        <span>{{ $thread->user->name }}</span>
                                        <span class="mx-1 text-gray-300">•</span>
                                        <span>{{ $thread->created_at->diffForHumans() }}</span>
                                        @if($thread->is_pinned)
                                            <span class="inline-flex items-center gap-1 rounded-full border border-amber-400 px-2 py-0.5 text-[11px] font-semibold text-amber-600">
                                                <i data-lucide="pin" class="h-3 w-3"></i> Épinglé
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('forum.show', $thread) }}">
                                            <h3 class="text-lg font-semibold text-gray-900 hover:text-gray-700">{{ $thread->title }}</h3>
                                        </a>
                                        <p class="mt-2 line-clamp-3 text-sm text-gray-700">
                                            {{ Str::limit(strip_tags($thread->body), 220) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex shrink-0 items-center gap-3 text-sm text-gray-600">
                                <div class="flex items-center gap-1.5 rounded-full border border-gray-200 px-3 py-1 font-semibold text-gray-700">
                                    <i data-lucide="messages-square" class="h-4 w-4"></i>
                                    {{ $thread->replies_count }}
                                </div>
                                <div class="flex items-center gap-1.5 rounded-full border border-gray-200 px-3 py-1 font-semibold text-gray-700">
                                    <i data-lucide="eye" class="h-4 w-4"></i>
                                    {{ number_format($thread->views) }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center justify-between border-t border-gray-200 pt-4 text-xs uppercase tracking-[0.28em] text-gray-500">
                            <span>Activité {{ optional($thread->last_activity_at ?? $thread->updated_at ?? $thread->created_at)->diffForHumans() }}</span>
                            <a href="{{ route('forum.show', $thread) }}" class="inline-flex items-center gap-2 text-xs font-semibold text-gray-900 hover:text-gray-700">
                                Voir les détails
                                <i data-lucide="arrow-up-right" class="h-3 w-3"></i>
                            </a>
                        </div>
                    </article>
                @endforeach

                {{ $threads->links() }}
            </div>
        </div>
    </div>
</section>
@endsection

