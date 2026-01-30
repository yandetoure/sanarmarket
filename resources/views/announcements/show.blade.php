@extends('layouts.app')

@section('title', $announcement->title)

@section('content')
    <div class="bg-slate-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex items-center space-x-2 text-xs font-bold uppercase tracking-widest text-slate-400 mb-8"
                data-aos="fade-down">
                <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Accueil</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <a href="{{ route('announcements.index') }}"
                    class="hover:text-primary-600 transition-colors">Marketplace</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-slate-900">{{ $announcement->category->name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Media Gallery -->
                <div class="lg:col-span-7 space-y-6" data-aos="fade-right">
                    @php
                        $mediaGallery = $announcement->media;
                    @endphp

                    <div
                        class="relative group bg-white rounded-[2.5rem] overflow-hidden shadow-2xl border border-white shadow-primary-100">
                        <div class="aspect-[4/3] bg-slate-100 flex items-center justify-center relative shadow-inner"
                            id="main-display">
                            @if($mediaGallery->isNotEmpty())
                                @php $first = $mediaGallery->first(); @endphp
                                @if($first->isVideo())
                                    <video src="{{ storage_url($first->path) }}" controls
                                        class="w-full h-full object-cover"></video>
                                @else
                                    <img src="{{ storage_url($first->path) }}" alt="{{ $announcement->title }}"
                                        class="w-full h-full object-cover">
                                @endif
                            @else
                                <img src="{{ asset('images/marketplace.png') }}"
                                    class="w-full h-full object-cover opacity-20 grayscale">
                            @endif
                        </div>
                    </div>

                    @if($mediaGallery->count() > 1)
                        <div class="flex gap-4 overflow-x-auto pb-4 px-2 no-scrollbar">
                            @foreach($mediaGallery as $media)
                                <button type="button"
                                    onclick="updateMainDisplay('{{ storage_url($media->path) }}', '{{ $media->isVideo() ? 'video' : 'image' }}')"
                                    class="w-24 h-24 rounded-2xl overflow-hidden border-2 border-transparent hover:border-primary-500 transition-all flex-shrink-0 shadow-lg bg-white">
                                    @if($media->isVideo())
                                        <video src="{{ storage_url($media->path) }}" class="w-full h-full object-cover"></video>
                                    @else
                                        <img src="{{ storage_url($media->path) }}" class="w-full h-full object-cover">
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Details Sidebar -->
                <div class="lg:col-span-5 space-y-8" data-aos="fade-left">
                    <div class="glass p-8 md:p-10 rounded-[2.5rem] shadow-2xl border-white/60">
                        <div class="flex items-center justify-between mb-6">
                            <x-badge variant="primary" size="md" class="glass border-primary-100 text-primary-700">
                                {{ $announcement->category->name }}
                            </x-badge>
                            <span class="text-xs font-bold text-slate-400 flex items-center uppercase tracking-widest">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $announcement->formatted_date }}
                            </span>
                        </div>

                        <h1 class="text-3xl md:text-4xl font-display font-black text-slate-900 mb-4 leading-tight">
                            {{ $announcement->title }}
                        </h1>

                        <div class="flex items-center text-slate-500 mb-8 pb-8 border-b border-slate-100">
                            <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-sm font-bold">{{ $announcement->location }}</span>
                        </div>

                        <div
                            class="bg-primary-600 rounded-3xl p-6 text-white shadow-2xl shadow-primary-200 mb-10 relative overflow-hidden group">
                            <div
                                class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700">
                            </div>
                            <p class="text-xs font-bold uppercase tracking-widest opacity-80 mb-1">Prix de l'article</p>
                            <p class="text-4xl font-display font-black">
                                {{ number_format((float) $announcement->price, 0, ',', ' ') }} <span
                                    class="text-lg font-bold">FCFA</span>
                            </p>
                        </div>

                        <div class="space-y-4">
                            @if($announcement->phone)
                                <x-button href="tel:{{ $announcement->phone }}" variant="primary" size="lg"
                                    class="w-full shadow-xl shadow-primary-200 group">
                                    <svg class="w-5 h-5 mr-3 group-hover:rotate-12 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    Appeler le vendeur
                                </x-button>
                            @endif
                            <x-button variant="secondary" size="lg"
                                class="w-full bg-slate-100 hover:bg-slate-200 text-slate-900 border-transparent shadow-none">
                                Contacter par message
                            </x-button>
                        </div>
                    </div>

                    <!-- Seller Info -->
                    <div
                        class="bg-white p-8 rounded-[2rem] border border-slate-100 flex items-center space-x-4 shadow-sm hover:shadow-xl transition-all duration-500">
                        <div
                            class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center font-display font-black text-xl text-primary-600 border-2 border-white shadow-lg overflow-hidden">
                            @if($announcement->user->avatar)
                                <img src="{{ storage_url($announcement->user->avatar) }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($announcement->user->name, 0, 2)) }}
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-0.5">Vendu par</p>
                            <p class="text-lg font-display font-bold text-slate-900 leading-none">
                                {{ $announcement->user->name }}</p>
                            <p class="text-xs font-semibold text-emerald-600 mt-1 flex items-center">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full mr-1.5 animate-pulse"></span>
                                Membre vérifié
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Section -->
            <div class="mt-20 max-w-4xl" data-aos="fade-up">
                <h2 class="text-2xl font-display font-bold text-slate-900 mb-6">Description de l'offre</h2>
                <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed font-medium">
                    {!! nl2br(e($announcement->description)) !!}
                </div>
            </div>

            <!-- Similar Items -->
            <div class="mt-24 border-t border-slate-100 pt-20">
                <div class="flex items-end justify-between mb-12" data-aos="fade-up">
                    <div>
                        <h2 class="text-sm font-bold text-primary-600 uppercase tracking-widest mb-3">Suggestion</h2>
                        <h3 class="text-4xl font-display font-extrabold text-slate-900">Annonces <span
                                class="text-gradient">Similaires</span></h3>
                    </div>
                    <x-button href="{{ route('announcements.index', ['category' => $announcement->category->slug]) }}"
                        variant="ghost">
                        Voir plus
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </x-button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach(\App\Models\Announcement::where('category_id', $announcement->category_id)->where('id', '!=', $announcement->id)->latest()->take(4)->get() as $index => $similar)
                        <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <x-card :title="$similar->title" :price="$similar->price"
                                :image="storage_url($similar->media->first()?->path)" :category="$similar->category->name"
                                :url="route('announcements.show', $similar)" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateMainDisplay(src, type) {
            const display = document.getElementById('main-display');
            display.style.opacity = '0';
            setTimeout(() => {
                if (type === 'video') {
                    display.innerHTML = `<video src="${src}" controls class="w-full h-full object-cover"></video>`;
                } else {
                    display.innerHTML = `<img src="${src}" class="w-full h-full object-cover">`;
                }
                display.style.opacity = '1';
            }, 300);
        }
    </script>

    <style>
        #main-display {
            transition: opacity 0.3s ease;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endsection