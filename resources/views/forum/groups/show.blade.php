@extends('layouts.app')

@section('title', $group->name . ' - Forum')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp
<section class="bg-white border-b">
    <div class="container mx-auto px-4 py-10">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-col gap-3">
                @if($group->cover_image)
                    <div class="overflow-hidden rounded-3xl border border-slate-200">
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($group->cover_image) }}" alt="Illustration du groupe {{ $group->name }}" class="h-40 w-full object-cover">
                    </div>
                @endif
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Groupe</p>
                    <h1 class="text-3xl font-semibold text-slate-900">{{ $group->name }}</h1>
                    @if($group->description)
                        <p class="mt-2 max-w-2xl text-muted-foreground">{{ $group->description }}</p>
                    @endif
                </div>
                @if($group->rules)
                    <div class="rounded-2xl bg-slate-100 px-4 py-3 text-sm text-slate-600">
                        <p class="font-semibold uppercase tracking-[0.24em] text-slate-500">Règles</p>
                        <p class="mt-2 whitespace-pre-line">{{ $group->rules }}</p>
                    </div>
                @endif
            </div>
            <div class="flex flex-wrap items-center gap-3">
                @auth
                    @if($isOwner)
                        <a href="{{ route('forum.groups.edit', $group) }}"
                           class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-5 py-2 text-sm font-semibold uppercase tracking-[0.24em] text-slate-600 transition hover:border-slate-400">
                            <i data-lucide="settings" class="h-4 w-4"></i>
                            Configurer
                        </a>
                    @endif
                    @if($isBanned ?? false)
                        <span class="inline-flex items-center gap-2 rounded-full border border-red-500 px-5 py-2 text-sm font-semibold uppercase tracking-[0.24em] text-red-600">
                            <i data-lucide="shield-alert" class="h-4 w-4"></i>
                            Vous êtes banni
                        </span>
                    @elseif(!$isMember)
                        <form action="{{ route('forum.groups.join', $group) }}" method="POST">
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
    </div>
</section>

<section class="py-10">
    <div class="container mx-auto px-4">
        @if($isOwner)
            <div class="mb-8 grid gap-6 lg:grid-cols-2">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-900">Membres actifs</h2>
                        <span class="text-sm text-slate-500">{{ $activeMembers->count() }}</span>
                    </div>
                    <div class="mt-4 space-y-3">
                        @forelse($activeMembers as $membership)
                            <div class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-3">
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">{{ $membership->user->name }}</p>
                                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ $membership->role }}</p>
                                </div>
                                @if($membership->user_id !== $group->owner_id)
                                    <form action="{{ route('forum.groups.members.ban', [$group, $membership->user]) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 rounded-full border border-red-500 px-3 py-1 text-xs font-semibold text-red-600 transition hover:bg-red-50">
                                            <i data-lucide="ban" class="h-3 w-3"></i>
                                            Bannir
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">Aucun membre actif.</p>
                        @endforelse
                    </div>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-900">Membres bannis</h2>
                        <span class="text-sm text-slate-500">{{ $bannedMembers->count() }}</span>
                    </div>
                    <div class="mt-4 space-y-3">
                        @forelse($bannedMembers as $membership)
                            <div class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-3">
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">{{ $membership->user->name }}</p>
                                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Banni</p>
                                </div>
                                <form action="{{ route('forum.groups.members.unban', [$group, $membership->user]) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center gap-1 rounded-full border border-emerald-500 px-3 py-1 text-xs font-semibold text-emerald-600 transition hover:bg-emerald-50">
                                        <i data-lucide="rotate-ccw" class="h-3 w-3"></i>
                                        Réintégrer
                                    </button>
                                </form>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">Aucun membre banni.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="hidden bg-slate-50 px-6 py-3 text-sm font-semibold uppercase tracking-[0.28em] text-slate-500 sm:grid sm:grid-cols-6">
                <span class="col-span-3">Sujet</span>
                <span class="col-span-1">Réponses</span>
                <span class="col-span-1">Vues</span>
                <span class="col-span-1">Activité</span>
            </div>

            <div class="divide-y divide-slate-200">
                @forelse($threads as $thread)
                    <a href="{{ route('forum.show', $thread) }}"
                       class="flex flex-col gap-4 px-6 py-5 transition hover:bg-slate-50 sm:grid sm:grid-cols-6 sm:items-center">
                        <div class="col-span-3">
                            <div class="flex items-center gap-2 text-xs uppercase tracking-[0.28em] text-slate-400">
                                <span>{{ $thread->user->name }}</span>
                                <span class="mx-1 text-slate-300">•</span>
                                <span>{{ $thread->created_at->diffForHumans() }}</span>
                                @if($thread->is_pinned)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2 py-0.5 text-[11px] font-semibold text-amber-700">
                                        <i data-lucide="pin" class="h-3 w-3"></i> Épinglé
                                    </span>
                                @endif
                            </div>
                            <h2 class="mt-2 text-xl font-semibold text-slate-900">{{ $thread->title }}</h2>
                            <p class="mt-2 line-clamp-2 text-sm text-slate-500">
                                {{ Str::limit(strip_tags($thread->body), 200) }}
                            </p>
                        </div>
                        <div class="col-span-1 text-sm font-semibold text-slate-700 sm:text-center">
                            {{ $thread->replies_count }}
                        </div>
                        <div class="col-span-1 text-sm font-semibold text-slate-700 sm:text-center">
                            {{ number_format($thread->views) }}
                        </div>
                        <div class="col-span-1 text-sm text-slate-500 sm:text-right">
                            {{ optional($thread->last_activity_at ?? $thread->updated_at ?? $thread->created_at)->diffForHumans() }}
                        </div>
                    </a>
                @empty
                    <div class="px-6 py-10 text-center text-slate-500">
                        <i data-lucide="message-circle-off" class="mx-auto mb-4 h-10 w-10 text-slate-400"></i>
                        <p>Aucun sujet pour ce groupe pour l’instant.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-8">
            {{ $threads->links() }}
        </div>
    </div>
</section>
@endsection

