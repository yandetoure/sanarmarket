@extends('layouts.app')

@section('title', $thread->title . ' - Forum')

@php
    $shareUrl = request()->fullUrl();
    $engagementScore = min(100, (int) round(($thread->replies_count * 4) + min($thread->views / 50, 60)));
@endphp

@section('content')
<style>
    .forum-hero {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #0b1328 0%, #111c3a 40%, #182544 100%);
        color: #f5f7ff;
    }
    .forum-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top, rgba(255,255,255,0.35), transparent 60%);
        opacity: .5;
    }
    .forum-container {
        position: relative;
        z-index: 1;
        max-width: 1100px;
        margin: 0 auto;
        padding: 60px 24px 50px;
    }
    .forum-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        font-size: 0.68rem;
        letter-spacing: 0.28em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.7);
    }
    .forum-chip {
        background: rgba(255,255,255,0.12);
        padding: 6px 12px;
        border-radius: 999px;
        color: #fff;
        letter-spacing: 0.3em;
    }
    .forum-title {
        margin-top: 20px;
        font-size: clamp(2rem, 4vw, 3.25rem);
        font-weight: 600;
        color: #fff;
    }
    .forum-stats {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        margin: 30px 0 0;
    }
    .forum-stat-card {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 18px;
        border-radius: 18px;
        border: 1px solid rgba(255,255,255,0.25);
        background: rgba(255,255,255,0.08);
        font-weight: 600;
        color: #f5f7ff;
    }
    .forum-hero-actions {
        margin-top: 18px;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }
    .forum-btn-outline,
    .forum-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 999px;
        padding: 12px 22px;
        font-size: 0.9rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: background .2s ease, color .2s ease;
    }
    .forum-btn-outline {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.3);
        color: #f5f7ff;
    }
    .forum-btn-outline:hover { background: rgba(255,255,255,0.18); }
    .forum-btn-primary {
        background: #fff;
        color: #131b36;
    }
    .forum-btn-primary:hover { background: #f0f2ff; }
    .forum-body {
        background: #f5f7fb;
        padding: 60px 0;
    }
    .forum-grid {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 24px;
        display: grid;
        gap: 32px;
    }
    @media (min-width: 1024px) {
        .forum-grid {
            grid-template-columns: minmax(0, 2fr) minmax(280px, 340px);
        }
    }
    .forum-card {
        background: #fff;
        border-radius: 28px;
        border: 1px solid rgba(19,27,54,0.06);
        box-shadow: 0 25px 55px -30px rgba(10,18,73,0.25);
        padding: 32px;
    }
    .forum-card h2 {
        font-size: 1.35rem;
        margin-bottom: 18px;
        color: #131b36;
    }
    .forum-content img {
        max-width: 100%;
        border-radius: 24px;
        margin-bottom: 24px;
    }
    .forum-content p {
        line-height: 1.7;
        color: #455065;
        margin-bottom: 16px;
    }
    .reply-card {
        position: relative;
        background: #fff;
        border-radius: 24px;
        border: 1px solid rgba(19,27,54,0.08);
        padding: 24px 28px;
        box-shadow: 0 18px 35px -22px rgba(9,13,32,0.45);
    }
    .reply-card::before {
        content: "";
        position: absolute;
        left: 24px;
        top: 20px;
        bottom: 20px;
        width: 3px;
        background: linear-gradient(180deg, #6b7bff 0%, #9b5bff 100%);
        border-radius: 999px;
    }
    .reply-card-body {
        padding-left: 28px;
    }
    .reply-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.85rem;
        color: #687086;
        margin-bottom: 10px;
    }
    .reply-meta span:first-child {
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.18em;
        color: #28304c;
        font-size: 0.78rem;
    }
    .reply-text {
        color: #373f58;
        font-size: 1rem;
        line-height: 1.65;
    }
    .reply-form textarea {
        width: 100%;
        border-radius: 18px;
        border: 1px solid rgba(19,27,54,0.08);
        padding: 16px 18px;
        font-size: 1rem;
        min-height: 160px;
        resize: vertical;
        font-family: inherit;
    }
    .reply-form textarea:focus {
        outline: none;
        border-color: #6b7bff;
        box-shadow: 0 0 0 3px rgba(107,123,255,0.2);
    }
    .reply-form-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        color: #606781;
        flex-wrap: wrap;
        gap: 12px;
    }
    .reply-submit {
        border: none;
        border-radius: 999px;
        padding: 12px 26px;
        background: #111b3a;
        color: #fff;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.18em;
        cursor: pointer;
        transition: background .2s ease;
    }
    .reply-submit:hover { background: #141f47; }
    .sidebar-card {
        background: #fff;
        border-radius: 24px;
        border: 1px solid rgba(19,27,54,0.06);
        padding: 24px;
        box-shadow: 0 25px 45px -40px rgba(9,13,32,0.7);
    }
    .sidebar-card + .sidebar-card { margin-top: 18px; }
    .sidebar-label {
        font-size: 0.7rem;
        letter-spacing: 0.28em;
        text-transform: uppercase;
        color: #7c859e;
    }
    .sidebar-group-desc {
        margin-top: 12px;
        font-size: 0.95rem;
        color: #4b5067;
        line-height: 1.5;
    }
    .sidebar-cta {
        margin-top: 18px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }
    .sidebar-cta button,
    .sidebar-cta a,
    .sidebar-cta span {
        border-radius: 999px;
        padding: 10px 20px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        border: 1px solid rgba(19,27,54,0.1);
        background: #f8f9ff;
        color: #1c2240;
        text-decoration: none;
        cursor: pointer;
    }
    .sidebar-share button,
    .sidebar-share a {
        width: 100%;
        justify-content: space-between;
    }
    .pill-muted {
        background: rgba(107, 123, 255, 0.12);
        color: #3a4683;
        border: 1px solid rgba(107,123,255,0.3);
    }
</style>

<section class="forum-hero">
    <div class="forum-container">
        <div class="forum-meta">
            <span class="forum-chip">{{ optional($thread->group)->name ?? 'Groupe inconnu' }}</span>
            <span>{{ $thread->user->name }}</span>
            <span>•</span>
            <span>Publié {{ $thread->created_at->diffForHumans() }}</span>
        </div>
        <h1 class="forum-title">{{ $thread->title }}</h1>
        <div class="forum-stats">
            <div class="forum-stat-card">
                <i data-lucide="messages-square" class="h-4 w-4"></i>
                {{ $thread->replies_count }} réponses
            </div>
            <div class="forum-stat-card">
                <i data-lucide="eye" class="h-4 w-4"></i>
                {{ number_format($thread->views) }} vues
            </div>
        </div>
        <div class="forum-hero-actions">
            <button type="button" data-copy-link="{{ $shareUrl }}" class="forum-btn-outline">
                <i data-lucide="link-2" class="h-4 w-4"></i>
                Copier le lien
            </button>
            <a href="#replies" class="forum-btn-primary">
                <i data-lucide="corner-right-down" class="h-4 w-4"></i>
                Aller aux réponses
            </a>
        </div>
    </div>
</section>

<section class="forum-body">
    <div class="forum-grid">
        <div class="forum-column">
            <article class="forum-card forum-content">
                @if($thread->cover_image)
                    <img src="{{ asset('storage/' . $thread->cover_image) }}" alt="{{ $thread->title }}">
                @endif
                {!! nl2br(e($thread->body)) !!}
            </article>

            <div id="replies" class="forum-card" style="padding:28px;">
                <div class="reply-header" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
                    <h2 style="margin:0;font-size:1.35rem;color:#0f1834;">Réponses</h2>
                    <span style="font-size:0.9rem;color:#6b728c;">{{ $thread->replies_count }} contributions</span>
                </div>

                <div class="reply-stack" style="display:flex;flex-direction:column;gap:18px;">
                    @forelse($replies as $index => $reply)
                        <div class="reply-card">
                            <div class="reply-card-body">
                                <div class="reply-meta">
                                    <span>{{ $reply->user->name }}</span>
                                    <span>•</span>
                                    <span>{{ $reply->created_at->diffForHumans() }}</span>
                                    <span class="pill-muted">#{{ $replies->firstItem() + $index }}</span>
                                </div>
                                <div class="reply-text">
                                    {!! nl2br(e($reply->body)) !!}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="text-align:center;padding:40px;border:1px dashed rgba(19,27,54,0.2);border-radius:22px;color:#6b728c;">
                            Soyez le premier à répondre à ce sujet.
                        </div>
                    @endforelse
                </div>

                <div style="margin-top:24px;">
                    {{ $replies->links() }}
                </div>
            </div>

            <div class="forum-card reply-form">
                @auth
                    @if($thread->is_locked)
                        <p style="text-align:center;font-weight:600;letter-spacing:0.24em;color:#a0a6bb;">Ce sujet est verrouillé.</p>
                    @elseif($isBanned)
                        <p style="text-align:center;font-weight:600;letter-spacing:0.24em;color:#d04848;">Vous avez été banni de ce groupe.</p>
                    @elseif(!$isMember)
                        <p style="text-align:center;font-weight:600;letter-spacing:0.24em;color:#a0a6bb;">Rejoignez le groupe pour participer.</p>
                    @else
                        <form action="{{ route('forum.reply.store', $thread) }}" method="POST">
                            @csrf
                            <label for="body" style="display:block;font-size:0.8rem;font-weight:600;letter-spacing:0.24em;color:#313754;text-transform:uppercase;">Votre réponse</label>
                            <textarea id="body" name="body" required placeholder="Partagez votre expérience, posez une question complémentaire…">{{ old('body') }}</textarea>
                            @error('body')
                                <p style="color:#d04848;font-size:0.9rem;margin-top:6px;">{{ $message }}</p>
                            @enderror
                            <div class="reply-form-footer" style="margin-top:18px;">
                                <span>Conseil : soyez précis et bienveillant.</span>
                                <button type="submit" class="reply-submit">
                                    <i data-lucide="corner-down-right" class="h-4 w-4"></i>
                                    Publier
                                </button>
                            </div>
                        </form>
                    @endif
                @else
                    <p style="text-align:center;font-weight:600;letter-spacing:0.24em;color:#7a8098;">
                        <a href="{{ route('login') }}" style="color:#111b3a;text-decoration:underline;">Connectez-vous</a> pour participer.
                    </p>
                @endauth
            </div>
        </div>

        <aside>
            <div class="sidebar-card">
                <p class="sidebar-label">Activité</p>
                <div style="margin:18px 0;">
                    <div style="display:flex;justify-content:space-between;font-size:0.9rem;color:#69708a;">
                        <span>Engagement</span>
                        <strong style="color:#111b3a;font-size:1rem;">{{ $engagementScore }}%</strong>
                    </div>
                    <div style="height:8px;border-radius:999px;background:#e1e5f5;margin-top:8px;">
                        <div style="height:100%;border-radius:inherit;background:linear-gradient(90deg,#6b7bff,#9b5bff);width:{{ $engagementScore }}%;"></div>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;font-size:0.85rem;">
                    <div style="background:#f7f8ff;border-radius:20px;padding:18px;text-align:center;">
                        <p style="font-size:1.5rem;font-weight:600;margin:0;color:#111b3a;">{{ $thread->replies_count }}</p>
                        <span style="letter-spacing:0.2em;font-size:0.65rem;color:#6c7492;">Réponses</span>
                    </div>
                    <div style="background:#f7f8ff;border-radius:20px;padding:18px;text-align:center;">
                        <p style="font-size:1.5rem;font-weight:600;margin:0;color:#111b3a;">{{ number_format($thread->views) }}</p>
                        <span style="letter-spacing:0.2em;font-size:0.65rem;color:#6c7492;">Vues</span>
                    </div>
                </div>
            </div>

            @if($thread->group)
                <div class="sidebar-card">
                    <p class="sidebar-label">Groupe</p>
                    <h3 style="margin-top:6px;margin-bottom:8px;font-size:1.2rem;color:#111b3a;">{{ $thread->group->name }}</h3>
                    @if($thread->group->description)
                        <p class="sidebar-group-desc">{{ \Illuminate\Support\Str::limit($thread->group->description, 140) }}</p>
                    @endif
                    <div class="sidebar-cta">
                        @auth
                            @if($isOwner)
                                <a href="{{ route('forum.groups.edit', $thread->group) }}">
                                    <i data-lucide="settings" class="h-4 w-4"></i> Gérer
                                </a>
                            @endif
                            @if($isBanned)
                                <span class="pill-muted">
                                    <i data-lucide="shield-alert" class="h-4 w-4"></i>
                                    Banni
                                </span>
                            @elseif(!$isMember)
                                <form action="{{ route('forum.groups.join', $thread->group) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="background:#0f9e5e;color:#fff;border:none;">
                                        <i data-lucide="user-plus" class="h-4 w-4"></i>
                                        Rejoindre
                                    </button>
                                </form>
                            @else
                                <span class="pill-muted" style="background:rgba(15,158,94,0.15);color:#0b8c51;border-color:rgba(11,140,81,0.3);">
                                    <i data-lucide="badge-check" class="h-4 w-4"></i>
                                    Membre
                                </span>
                            @endif
                        @else
                            <a href="{{ route('login') }}">
                                <i data-lucide="lock" class="h-4 w-4"></i>
                                Se connecter
                            </a>
                        @endauth
                    </div>
                </div>
            @endif

            <div class="sidebar-card sidebar-share">
                <p class="sidebar-label">Partager</p>
                <button type="button" data-copy-link="{{ $shareUrl }}" class="forum-btn-outline" style="width:100%;justify-content:space-between;margin-top:16px;background:#f8f9ff;color:#111b3a;">
                    <span style="display:flex;align-items:center;gap:10px;">
                        <i data-lucide="copy" class="h-4 w-4"></i>
                        Copier le lien
                    </span>
                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                </button>
                <a href="mailto:?subject={{ rawurlencode($thread->title) }}&body={{ rawurlencode($shareUrl) }}"
                   class="forum-btn-outline" style="width:100%;justify-content:space-between;margin-top:10px;background:#f8f9ff;color:#111b3a;text-decoration:none;">
                    <span style="display:flex;align-items:center;gap:10px;">
                        <i data-lucide="mail" class="h-4 w-4"></i>
                        Envoyer par email
                    </span>
                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                </a>
            </div>
        </aside>
    </div>
</section>
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
                                    class="inline-flex items-center gap-2 rounded-full bg-gray-900 px-6 py-2.5 text-sm font-semibold uppercase tracking-[0.24em] text-white transition hover:bg-gray-700">
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

@section('scripts')
<script>
    function initLucideIcons() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function initCopyButtons() {
        document.querySelectorAll('[data-copy-link]').forEach((button) => {
            button.addEventListener('click', async () => {
                const link = button.getAttribute('data-copy-link');
                if (!link) {
                    return;
                }

                try {
                    await navigator.clipboard.writeText(link);
                    const originalText = button.textContent;
                    button.innerHTML = '<i data-lucide="check" class="h-4 w-4"></i> Copié !';
                    initLucideIcons();
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        initLucideIcons();
                    }, 1800);
                } catch (error) {
                    console.error('Impossible de copier le lien', error);
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        initLucideIcons();
        initCopyButtons();
    });

    if (document.readyState !== 'loading') {
        initLucideIcons();
        initCopyButtons();
    }
</script>
@endsection

