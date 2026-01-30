@extends('layouts.app')

@section('title', $thread->title . ' - Forum')

@php
    $shareUrl = request()->fullUrl();
    $engagementScore = min(100, (int) round(($thread->replies_count * 4) + min($thread->views / 50, 60)));
@endphp

@section('content')
    <div class="bg-slate-50 min-h-screen pb-20">
        <!-- Sophisticated Discussion Hero -->
        <header class="relative py-20 overflow-hidden bg-slate-900">
            <div class="absolute inset-0 z-0">
                @if($thread->cover_image)
                    <img src="{{ asset('storage/' . $thread->cover_image) }}" alt=""
                        class="w-full h-full object-cover opacity-30 blur-sm">
                @else
                    <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&q=80&w=2000"
                        alt="" class="w-full h-full object-cover opacity-20">
                @endif
                <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900 to-slate-900"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div data-aos="fade-up">
                    <nav
                        class="flex items-center space-x-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-8">
                        <a href="{{ route('forum.index') }}" class="hover:text-white transition-colors">Forum</a>
                        <span>/</span>
                        <a href="{{ route('forum.index', ['group' => optional($thread->group)->slug]) }}"
                            class="text-primary-400 hover:text-primary-300 transition-colors">{{ optional($thread->group)->name ?? 'Général' }}</a>
                    </nav>

                    <h1 class="text-3xl md:text-5xl font-display font-black text-white mb-8 leading-tight max-w-4xl">
                        {{ $thread->title }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-6">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center text-white font-black text-sm shadow-lg">
                                {{ strtoupper(substr($thread->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white">{{ $thread->user->name }}</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Posté
                                    {{ $thread->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        <div class="h-8 w-px bg-white/10 hidden md:block"></div>

                        <div class="flex items-center space-x-6">
                            <div class="text-center">
                                <p class="text-lg font-display font-black text-white leading-none">
                                    {{ $thread->replies_count }}</p>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Réponses</p>
                            </div>
                            <div class="text-center">
                                <p class="text-lg font-display font-black text-white leading-none">
                                    {{ number_format($thread->views) }}</p>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Vues</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3 ml-auto">
                            <button data-copy-link="{{ $shareUrl }}"
                                class="p-3 rounded-xl bg-white/5 border border-white/10 text-white hover:bg-white/10 transition-all group relative">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                                    </path>
                                </svg>
                            </button>
                            <x-button href="#replies" variant="primary" size="md"
                                class="rounded-xl shadow-2xl shadow-primary-500/20">Participer</x-button>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
            <div class="grid lg:grid-cols-3 gap-10">

                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-10">
                    <article class="glass p-10 md:p-12 rounded-[3rem] border-white/60 shadow-2xl shadow-slate-200/50"
                        data-aos="fade-up">
                        @if($thread->cover_image)
                            <div class="rounded-[2.5rem] overflow-hidden mb-10 shadow-lg">
                                <img src="{{ asset('storage/' . $thread->cover_image) }}" alt="{{ $thread->title }}"
                                    class="w-full h-auto">
                            </div>
                        @endif
                        <div class="prose prose-slate prose-lg max-w-none text-slate-700 font-medium leading-relaxed">
                            {!! nl2br(e($thread->body)) !!}
                        </div>
                    </article>

                    <!-- Replies Section -->
                    <div id="replies" class="space-y-8">
                        <div class="flex items-center justify-between px-6">
                            <h2 class="text-2xl font-display font-black text-slate-900">Discussion</h2>
                            <span
                                class="text-[10px] font-black uppercase tracking-widest text-slate-400 bg-slate-100 px-3 py-1 rounded-full">{{ $thread->replies_count }}
                                contributions</span>
                        </div>

                        <div class="space-y-6">
                            @forelse($replies as $index => $reply)
                                <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-lg shadow-slate-100/50 hover:shadow-xl transition-all"
                                    data-aos="fade-up">
                                    <div class="flex items-start space-x-4">
                                        <div
                                            class="w-10 h-10 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 font-bold text-xs">
                                            {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-4">
                                                <div>
                                                    <p class="text-sm font-black text-slate-900">{{ $reply->user->name }}</p>
                                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                                        {{ $reply->created_at->diffForHumans() }}</p>
                                                </div>
                                                <span
                                                    class="text-[10px] font-black text-slate-300">#{{ $replies->firstItem() + $index }}</span>
                                            </div>
                                            <div class="text-slate-600 font-medium leading-relaxed">
                                                {!! nl2br(e($reply->body)) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="py-20 text-center glass rounded-[3rem] border-slate-100" data-aos="zoom-in">
                                    <p class="text-slate-400 font-bold italic">Aucune réponse pour le moment. Lancez la
                                        discussion !</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-8 flex justify-center">
                            {{ $replies->links() }}
                        </div>
                    </div>

                    <!-- Reply Form -->
                    <div class="glass p-10 rounded-[3rem] border-white/60 shadow-2xl shadow-primary-50/50"
                        data-aos="fade-up">
                        @auth
                            @if($thread->is_locked)
                                <div class="text-center py-6">
                                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-black text-slate-400 uppercase tracking-widest">Ce sujet est verrouillé
                                    </p>
                                </div>
                            @elseif($isBanned)
                                <div class="text-center py-6">
                                    <p class="text-sm font-black text-red-500 uppercase tracking-widest">Vous avez été banni de ce
                                        groupe</p>
                                </div>
                            @elseif(!$isMember && $thread->group_id)
                                <div class="text-center py-10">
                                    <p class="text-slate-500 font-medium mb-6">Vous devez rejoindre ce groupe pour participer à la
                                        discussion.</p>
                                    <form action="{{ route('forum.groups.join', $thread->group) }}" method="POST">
                                        @csrf
                                        <x-button type="submit" variant="primary">Rejoindre le groupe</x-button>
                                    </form>
                                </div>
                            @else
                                <h3 class="text-xl font-display font-black text-slate-900 mb-8">Votre contribution</h3>
                                <form action="{{ route('forum.reply.store', $thread) }}" method="POST" class="space-y-6">
                                    @csrf
                                    <textarea name="body" rows="6" required
                                        class="w-full glass-light p-6 rounded-[2rem] border-white/50 focus:border-primary-300 focus:ring-0 text-slate-700 font-medium placeholder-slate-300 transition-all"
                                        placeholder="Partagez votre avis ou apportez une réponse..."></textarea>
                                    <div class="flex items-center justify-between">
                                        <p class="text-xs text-slate-400 font-medium">Restez courtois et respectez la charte du
                                            campus.</p>
                                        <x-button type="submit" variant="primary" size="lg"
                                            class="shadow-xl shadow-primary-500/20">Publier la réponse</x-button>
                                    </div>
                                </form>
                            @endif
                        @else
                            <div class="text-center py-10">
                                <p class="text-slate-500 font-medium mb-6">Connectez-vous pour participer à ce sujet.</p>
                                <x-button href="{{ route('login') }}" variant="primary">Se connecter</x-button>
                            </div>
                        @endauth
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-10">
                    <div class="sticky top-32 space-y-10">
                        <!-- Engagement Card -->
                        <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-slate-200/50">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Indicateur
                                d'engagement</p>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-2xl font-display font-black text-slate-900">{{ $engagementScore }}%</span>
                                <span class="text-[10px] font-bold text-slate-400">Score de vitalité</span>
                            </div>
                            <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-primary-500 to-indigo-600 rounded-full"
                                    style="width: {{ $engagementScore }}%"></div>
                            </div>
                            <p class="mt-4 text-[10px] text-slate-400 font-medium leading-relaxed italic">Ce score reflète
                                l'activité récente et la popularité de ce sujet auprès des étudiants.</p>
                        </div>

                        <!-- Group Info -->
                        @if($thread->group)
                            <div
                                class="glass p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-indigo-50/50 bg-gradient-to-br from-white via-white to-indigo-50/20">
                                <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-4">À propos du
                                    groupe</p>
                                <h3 class="text-xl font-display font-black text-slate-900 mb-2">{{ $thread->group->name }}</h3>
                                <p class="text-xs text-slate-500 font-medium leading-relaxed mb-8 line-clamp-4">
                                    {{ $thread->group->description }}</p>
                                <x-button href="{{ route('forum.index', ['group' => $thread->group->slug]) }}"
                                    variant="secondary" size="sm" class="w-full">Voir tout le groupe</x-button>
                            </div>
                        @endif

                        <!-- Share Side Card -->
                        <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-slate-100/50">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Partager le
                                sujet</p>
                            <div class="space-y-4">
                                <button data-copy-link="{{ $shareUrl }}"
                                    class="flex items-center justify-between w-full p-4 rounded-2xl bg-slate-50 hover:bg-white border border-transparent hover:border-slate-100 hover:shadow-lg transition-all group">
                                    <span
                                        class="text-xs font-bold text-slate-600 group-hover:text-primary-600 transition-colors">Copier
                                        le lien</span>
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-primary-500 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </button>
                                <a href="mailto:?subject={{ rawurlencode($thread->title) }}&body={{ rawurlencode($shareUrl) }}"
                                    class="flex items-center justify-between w-full p-4 rounded-2xl bg-slate-50 hover:bg-white border border-transparent hover:border-slate-100 hover:shadow-lg transition-all group">
                                    <span
                                        class="text-xs font-bold text-slate-600 group-hover:text-primary-600 transition-colors">Envoyer
                                        par Email</span>
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-primary-500 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-copy-link]').forEach((button) => {
                button.addEventListener('click', async () => {
                    const link = button.getAttribute('data-copy-link');
                    try {
                        await navigator.clipboard.writeText(link);
                        const originalContent = button.innerHTML;
                        button.innerHTML = '<span class="text-xs font-bold text-emerald-500">Copié !</span>';
                        setTimeout(() => { button.innerHTML = originalContent; }, 2000);
                    } catch (err) {
                        console.error('Failed to copy: ', err);
                    }
                });
            });
        });
    </script>
@endsection