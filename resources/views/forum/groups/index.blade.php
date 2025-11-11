@extends('layouts.app')

@section('title', 'Groupes du forum')

@section('content')
<section class="bg-white border-b">
    <div class="container mx-auto px-4 py-10">
        <h1 class="text-3xl font-semibold text-slate-900">Groupes du forum</h1>
        <p class="mt-2 max-w-2xl text-muted-foreground">
            Rejoignez les communautés qui vous intéressent pour échanger avec les étudiants partageant vos centres d’intérêt.
        </p>
    </div>
</section>

<section class="py-10">
    <div class="container mx-auto px-4">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Explorer</p>
                <h2 class="text-xl font-semibold text-slate-900">Toutes les communautés</h2>
            </div>
            @auth
                <a href="{{ route('forum.groups.create') }}"
                   class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-5 py-2 text-sm font-semibold uppercase tracking-[0.24em] text-slate-600 transition hover:border-slate-400">
                    <i data-lucide="users-plus" class="h-4 w-4"></i>
                    Créer un groupe
                </a>
            @endauth
        </div>

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($groups as $group)
                @php
                    $isMember = in_array($group->id, $userGroupIds ?? []);
                    $isBanned = in_array($group->id, $bannedGroupIds ?? []);
                @endphp
                <div class="flex flex-col justify-between rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">{{ $group->name }}</h2>
                        @if($group->description)
                            <p class="mt-2 text-sm text-slate-600 line-clamp-3">{{ $group->description }}</p>
                        @endif
                    </div>
                    <div class="mt-4 flex items-center justify-between text-sm text-slate-500">
                        <span class="inline-flex items-center gap-1">
                            <i data-lucide="message-circle" class="h-4 w-4"></i>
                            {{ $group->threads_count }} sujets
                        </span>
                        @auth
                            @if($isBanned)
                                <span class="inline-flex items-center gap-1 rounded-full bg-red-500/10 px-3 py-1 text-xs font-semibold text-red-600">
                                    <i data-lucide="shield-alert" class="h-3 w-3"></i>
                                    Banni
                                </span>
                            @elseif($isMember)
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-700">
                                    <i data-lucide="badge-check" class="h-3 w-3"></i>
                                    Membre
                                </span>
                            @endif
                        @endauth
                    </div>
                    <div class="mt-6 flex items-center justify-between">
                        <a href="{{ route('forum.groups.show', $group) }}"
                           class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 transition hover:text-slate-900">
                            Voir les sujets
                            <i data-lucide="arrow-right" class="h-4 w-4"></i>
                        </a>
                        @auth
                            @if($isBanned)
                                <span class="text-xs font-semibold uppercase tracking-[0.24em] text-red-500">
                                    Accès refusé
                                </span>
                            @elseif(!$isMember)
                                <form action="{{ route('forum.groups.join', $group) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center gap-1 rounded-full border border-emerald-500 px-3 py-1 text-xs font-semibold text-emerald-600 transition hover:bg-emerald-50">
                                        <i data-lucide="user-plus" class="h-3 w-3"></i>
                                        Rejoindre
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="text-xs font-semibold text-emerald-600 underline">
                                Se connecter
                            </a>
                        @endauth
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-3xl border border-dashed border-slate-200 bg-white p-10 text-center text-slate-500">
                    Aucun groupe pour le moment.
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

