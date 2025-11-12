@extends('layouts.app')

@section('title', $thread->title . ' - Forum')

@section('content')
<section class="bg-white border-b">
    <div class="container mx-auto px-4 py-10">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <div class="flex items-center gap-3 text-xs uppercase tracking-[0.28em] text-slate-400">
                    <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.3em] text-slate-600">
                        {{ optional($thread->group)->name ?? 'Groupe inconnu' }}
                    </span>
                    <span>{{ $thread->user->name }}</span>
                    <span class="text-slate-300">•</span>
                    <span>Publié {{ $thread->created_at->diffForHumans() }}</span>
                </div>
                <h1 class="mt-3 text-3xl font-semibold text-slate-900">{{ $thread->title }}</h1>
            </div>
            <div class="flex items-center gap-4 text-sm text-slate-500">
                <span class="inline-flex items-center gap-1"><i data-lucide="messages-square" class="h-4 w-4"></i>{{ $thread->replies_count }}</span>
                <span class="inline-flex items-center gap-1"><i data-lucide="eye" class="h-4 w-4"></i>{{ number_format($thread->views) }}</span>
            </div>
        </div>
    </div>
</section>

<section class="py-10">
    <div class="container mx-auto px-4">
        @if($thread->group)
            <div class="mb-8 flex flex-col gap-4 rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Groupe</p>
                    <h2 class="text-2xl font-semibold text-slate-900">{{ $thread->group->name }}</h2>
                    @if($thread->group->description)
                        <p class="mt-1 text-sm text-slate-600">{{ $thread->group->description }}</p>
                    @endif
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    @auth
                        @if($isOwner)
                            <a href="{{ route('forum.groups.edit', $thread->group) }}"
                               class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-5 py-2 text-sm font-semibold uppercase tracking-[0.24em] text-slate-600 transition hover:border-slate-400">
                                <i data-lucide="settings" class="h-4 w-4"></i>
                                Configurer le groupe
                            </a>
                        @endif
                        @if($isBanned)
                            <span class="inline-flex items-center gap-2 rounded-full border border-red-500 px-5 py-2 text-sm font-semibold uppercase tracking-[0.24em] text-red-600">
                                <i data-lucide="shield-alert" class="h-4 w-4"></i>
                                Vous êtes banni
                            </span>
                        @elseif(!$isMember)
                            <form action="{{ route('forum.groups.join', $thread->group) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center gap-2 rounded-full border border-emerald-500 px-5 py-2 text-sm font-semibold uppercase tracking-[0.24em] text-emerald-600 transition hover:bg-emerald-50">
                                    <i data-lucide="user-plus" class="h-4 w-4"></i>
                                    Rejoindre le groupe
                                </button>
                            </form>
                        @else
                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-500/10 px-5 py-2 text-sm font-semibold uppercase tracking-[0.24em] text-emerald-700">
                                <i data-lucide="badge-check" class="h-4 w-4"></i>
                                Membre
                            </span>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-5 py-2 text-sm font-semibold uppercase tracking-[0.24em] text-slate-600 transition hover:border-slate-300">
                            <i data-lucide="lock" class="h-4 w-4"></i>
                            Connectez-vous pour rejoindre
                        </a>
                    @endauth
                </div>
            </div>
        @endif

        <article class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex flex-col gap-6 lg:flex-row lg:gap-8">
                <div class="flex-1 space-y-4">
                    @if($thread->cover_image)
                        <div class="overflow-hidden rounded-3xl border border-slate-200">
                            <img src="{{ asset('storage/' . $thread->cover_image) }}" alt="{{ $thread->title }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <div class="text-slate-700 leading-relaxed prose prose-slate max-w-none">
                        {!! nl2br(e($thread->body)) !!}
                    </div>
                </div>
            </div>
        </article>

        <div id="replies" class="mt-10 space-y-6">
            <h2 class="text-xl font-semibold text-slate-900">Réponses</h2>

            @forelse($replies as $reply)
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col gap-3 lg:flex-row lg:gap-6">
                        <div class="flex-shrink-0 text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">
                            {{ $reply->user->name }}
                            <div class="mt-1 text-[11px] font-medium text-slate-400">
                                {{ $reply->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <div class="flex-1 text-slate-700 leading-relaxed">
                            {!! nl2br(e($reply->body)) !!}
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-dashed border-slate-200 bg-white p-8 text-center text-slate-500">
                    <p>Soyez le premier à répondre à ce sujet.</p>
                </div>
            @endforelse

            {{ $replies->links() }}
        </div>

        <div class="mt-10 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            @auth
                @if($thread->is_locked)
                    <div class="text-center text-sm font-semibold uppercase tracking-[0.28em] text-slate-500">
                        Ce sujet est verrouillé. Vous ne pouvez plus répondre.
                    </div>
                @elseif($isBanned)
                    <div class="text-center text-sm font-semibold uppercase tracking-[0.28em] text-red-500">
                        Vous avez été banni de ce groupe.
                    </div>
                @elseif(!$isMember)
                    <div class="text-center text-sm font-semibold uppercase tracking-[0.28em] text-slate-500">
                        Rejoignez le groupe pour participer à la discussion.
                    </div>
                @else
                    <form action="{{ route('forum.reply.store', $thread) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="body" class="block text-sm font-semibold text-slate-700 uppercase tracking-[0.24em]">
                                Votre réponse
                            </label>
                            <textarea
                                id="body"
                                name="body"
                                rows="6"
                                required
                                class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-base text-slate-900 shadow-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200"
                                placeholder="Partagez votre expérience, posez une question complémentaire…"
                            >{{ old('body') }}</textarea>
                            @error('body')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-6 py-2.5 text-sm font-semibold uppercase tracking-[0.24em] text-white transition hover:bg-slate-700">
                                <i data-lucide="corner-down-right" class="h-4 w-4"></i>
                                Publier la réponse
                            </button>
                        </div>
                    </form>
                @endif
            @else
                <div class="text-center text-sm font-semibold uppercase tracking-[0.28em] text-slate-500">
                    <a href="{{ route('login') }}" class="text-slate-900 underline underline-offset-4">
                        Connectez-vous
                    </a>
                    pour participer à la discussion.
                </div>
            @endauth
        </div>
    </div>
</section>
@endsection

