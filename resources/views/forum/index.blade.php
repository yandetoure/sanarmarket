@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('title', 'Forum Étudiant - Sanar Market')

@section('content')
    <div class="bg-slate-50 min-h-screen">
        <!-- Forum Header -->
        <header class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-[4.5rem] z-30 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-12 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <h1 class="text-lg font-display font-black text-slate-900">Forum</h1>
                    @if($currentGroup)
                        <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                        <span
                            class="text-sm font-bold text-primary-600 bg-primary-50 px-3 py-0.5 rounded-full border border-primary-100">{{ $currentGroup->name }}</span>
                    @endif
                </div>

                <div class="flex items-center space-x-3">
                    @auth
                        <x-button href="{{ route('forum.create', $currentGroup ? ['group' => $currentGroup->id] : []) }}"
                            variant="primary" size="sm" class="rounded-xl">
                            + Nouveau sujet
                        </x-button>
                    @else
                        <x-button href="{{ route('login') }}" variant="secondary" size="sm" class="rounded-xl">Se
                            connecter</x-button>
                    @endauth
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row gap-8">

                <!-- Left Sidebar: navigation -->
                <aside class="lg:w-64 flex-shrink-0 space-y-6">
                    <div class="glass p-6 rounded-[2rem] border-white/60 shadow-xl shadow-slate-200/50 sticky top-32">
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-6">Communautés</h3>
                        <nav class="space-y-1">
                            <a href="{{ route('forum.index') }}"
                                class="flex items-center justify-between px-4 py-3 rounded-2xl text-sm font-bold transition-all {{ !$currentGroup ? 'bg-primary-600 text-white shadow-lg shadow-primary-200' : 'text-slate-600 hover:bg-slate-50' }}">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1a2.5 2.5 0 012.5 2.5v.659M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    Général
                                </span>
                            </a>
                            @foreach($groups as $group)
                                <a href="{{ route('forum.index', ['group' => $group->slug]) }}"
                                    class="flex items-center justify-between px-4 py-3 rounded-2xl text-sm font-bold transition-all {{ $currentGroup && $currentGroup->id === $group->id ? 'bg-primary-600 text-white shadow-lg shadow-primary-200' : 'text-slate-600 hover:bg-slate-50' }}">
                                    <span class="truncate">{{ $group->name }}</span>
                                    <span class="text-[10px] opacity-60 ml-2">{{ $group->members_count ?? 0 }}</span>
                                </a>
                            @endforeach
                        </nav>
                        <div class="mt-8 pt-6 border-t border-slate-100">
                            <x-button href="{{ route('forum.groups.index') }}" variant="ghost" size="sm"
                                class="w-full text-slate-400 group">
                                Découvrir plus
                                <svg class="w-3.5 h-3.5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </x-button>
                        </div>
                    </div>
                </aside>

                <!-- Main Feed -->
                <main class="flex-1 space-y-6">
                    @if($currentGroup)
                        <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-primary-50/50 mb-8"
                            data-aos="fade-up">
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-primary-500 mb-2">Groupe
                                actuelement</p>
                            <h2 class="text-2xl font-display font-black text-slate-900 mb-2">{{ $currentGroup->name }}</h2>
                            <p class="text-sm text-slate-500 font-medium leading-relaxed mb-6">{{ $currentGroup->description }}
                            </p>
                            <x-button href="{{ route('forum.groups.show', $currentGroup) }}" variant="secondary" size="sm">À
                                propos du groupe</x-button>
                        </div>
                    @endif

                    <div class="space-y-8">
                        @forelse($threads as $index => $thread)
                            <article
                                class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-primary-100 transition-all duration-500 overflow-hidden group"
                                data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                                <!-- Post Header -->
                                <div class="p-8 pb-4">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-10 h-10 rounded-2xl bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center text-white font-display font-black text-sm shadow-lg shadow-primary-100">
                                                {{ strtoupper(substr($thread->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-900 leading-tight">
                                                    {{ $thread->user->name }}</p>
                                                <p
                                                    class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">
                                                    {{ $thread->created_at->diffForHumans() }}
                                                    @if($thread->group)
                                                        dans <span
                                                            class="text-primary-600 underline">{{ $thread->group->name }}</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        @if($thread->is_pinned)
                                            <span
                                                class="bg-orange-50 text-orange-600 text-[10px] font-black p-2 rounded-xl border border-orange-100"><svg
                                                    class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M16 9V4.5L17.5 2H6.5L8 4.5V9C8 10.66 7.22 12.14 6 13.08V15H11V22H13V15H18V13.08C16.78 12.14 16 10.66 16 9Z">
                                                    </path>
                                                </svg></span>
                                        @endif
                                    </div>

                                    <a href="{{ route('forum.show', $thread) }}" class="block">
                                        <h4
                                            class="text-xl font-display font-bold text-slate-900 group-hover:text-primary-600 transition-colors mb-3 leading-tight">
                                            {{ $thread->title }}</h4>
                                    </a>
                                    <p class="text-sm text-slate-600 font-medium leading-relaxed line-clamp-3">
                                        {{ strip_tags($thread->body) }}
                                    </p>
                                </div>

                                @if($thread->cover_image)
                                    <div class="px-8 pb-4">
                                        <a href="{{ route('forum.show', $thread) }}"
                                            class="block rounded-[2rem] overflow-hidden bg-slate-100 aspect-video relative group">
                                            <img src="{{ asset('storage/' . $thread->cover_image) }}" alt="{{ $thread->title }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                            <div
                                                class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity">
                                            </div>
                                        </a>
                                    </div>
                                @endif

                                <!-- Interactions -->
                                <div
                                    class="px-8 py-6 bg-slate-50/50 border-t border-slate-50 flex items-center justify-between">
                                    <div class="flex items-center space-x-6">
                                        <button
                                            class="flex items-center space-x-2 text-slate-400 hover:text-primary-600 transition-colors group">
                                            <svg class="w-5 h-5 group-hover:fill-primary-100" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                                </path>
                                            </svg>
                                            <span class="text-xs font-bold">{{ $thread->replies_count }}</span>
                                        </button>
                                        <div class="flex items-center space-x-2 text-slate-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            <span class="text-xs font-bold">{{ number_format($thread->views) }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('forum.show', $thread) }}"
                                        class="text-[10px] font-black uppercase tracking-widest text-primary-600 hover:text-primary-700">Lire
                                        la discussion →</a>
                                </div>
                            </article>
                        @empty
                            <div class="py-24 text-center glass rounded-[3rem] border-slate-100" data-aos="zoom-in">
                                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.447-.617L3 20v-4l-1-1v-5a2 2 0 012-2h2">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-display font-bold text-slate-900 mb-2">Aucun sujet de discussion</h3>
                                <p class="text-slate-500 mb-8 max-w-xs mx-auto">Lancez la conversation ! Soyez le premier à
                                    poser une question ou partager une info.</p>
                                @auth
                                    <x-button href="{{ route('forum.create') }}" variant="primary">Lancer un sujet</x-button>
                                @endauth
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-12 flex justify-center">
                        {{ $threads->links() }}
                    </div>
                </main>

                <!-- Right Sidebar: Ads & Suggestions -->
                <aside class="hidden xl:block w-80 flex-shrink-0 space-y-8">
                    <div class="sticky top-32 space-y-8">
                        <!-- Sponsor Section -->
                        <div class="glass p-6 rounded-[2rem] border-white/60 shadow-xl shadow-slate-200/50">
                            <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-6 px-2">Sponsorisé
                            </h3>
                            <div class="space-y-6">
                                @forelse($advertisements as $ad)
                                    <div class="group cursor-pointer">
                                        <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-slate-100 mb-3 shadow-inner">
                                            <img src="{{ asset('storage/' . $ad->image) }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        </div>
                                        <h4
                                            class="text-sm font-bold text-slate-900 group-hover:text-primary-600 transition-colors leading-tight">
                                            {{ $ad->title }}</h4>
                                    </div>
                                @empty
                                    <div class="p-8 border-2 border-dashed border-slate-100 rounded-2xl text-center">
                                        <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest leading-loose">
                                            Votre publicité ici</p>
                                        <a href="#"
                                            class="text-[10px] font-black text-primary-500 hover:underline">Contactez-nous</a>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Suggestions -->
                        <div
                            class="glass p-8 rounded-[2rem] border-white/60 shadow-xl shadow-indigo-50/50 bg-gradient-to-br from-white to-indigo-50/30">
                            <h3 class="text-lg font-display font-black text-slate-900 mb-4">Besoin d'aide ?</h3>
                            <p class="text-xs text-slate-500 font-medium leading-relaxed mb-6">Rejoignez un groupe d'étude
                                ou demandez conseil à vos aînés sur le forum.</p>
                            <x-button href="{{ route('forum.groups.index') }}" variant="primary" size="sm"
                                class="w-full bg-indigo-600 shadow-indigo-100">Explorer les groupes</x-button>
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </div>
@endsection