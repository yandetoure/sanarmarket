@extends('layouts.app')

@section('title', $announcement->title . ' - Sanar Market')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    @php
        $mediaGallery = $announcement->media->map(function ($media) {
            return [
                'id' => $media->id,
                'type' => $media->isVideo() ? 'video' : 'image',
                'url' => $media->url,
            ];
        });

        if ($mediaGallery->isEmpty() && $announcement->image_url) {
            $mediaGallery = collect([[
                'id' => 'fallback',
                'type' => 'image',
                'url' => $announcement->image_url,
            ]]);
        }

        $primaryMedia = $mediaGallery->first();
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Media -->
        <div class="space-y-4">
            <div class="aspect-square rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center relative" data-primary-media data-media-alt="{{ $announcement->title }}">
                @if($primaryMedia)
                    @if($primaryMedia['type'] === 'video')
                        <video src="{{ $primaryMedia['url'] }}" controls class="w-full h-full object-cover"></video>
                    @else
                        <img src="{{ $primaryMedia['url'] }}" 
                             alt="{{ $announcement->title }}"
                             class="w-full h-full object-cover">
                    @endif
                @else
                    <div class="text-center text-muted-foreground px-6">
                        Aucun média disponible
                    </div>
                @endif
            </div>

            @if($mediaGallery->count() > 1)
                <div class="flex gap-3 overflow-x-auto pb-2 snap-x" data-media-thumbs>
                    @foreach($mediaGallery as $media)
                        <button 
                            type="button"
                            class="border border-border rounded-lg overflow-hidden w-20 h-20 flex-shrink-0 snap-start focus:outline-none focus-visible:ring-2 focus-visible:ring-primary hover:border-primary transition-colors"
                            data-media-trigger
                            data-media-type="{{ $media['type'] }}"
                            data-media-src="{{ $media['url'] }}"
                            data-media-alt="{{ $announcement->title }} - média {{ $loop->iteration }}"
                            aria-label="Voir le média {{ $loop->iteration }}">
                            @if($media['type'] === 'video')
                                <video src="{{ $media['url'] }}" class="w-full h-full object-cover" muted playsinline loop></video>
                            @else
                                <img src="{{ $media['url'] }}" alt="Média {{ $loop->iteration }}" class="w-full h-full object-cover" loading="lazy">
                            @endif
                        </button>
                    @endforeach
                </div>
            @endif
            
            @if($announcement->featured)
                <div class="bg-yellow-500 text-white px-3 py-2 rounded-lg text-center font-medium">
                    ⭐ Annonce en vedette
                </div>
            @endif
        </div>

        <!-- Details -->
        <div class="space-y-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $announcement->title }}</h1>
                <div class="flex items-center gap-4 text-muted-foreground mb-4">
                    <div class="flex items-center gap-1">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                        <span>{{ $announcement->location }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                        <span>{{ $announcement->formatted_date }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <i data-lucide="phone" class="w-4 h-4"></i>
                        @if($announcement->phone)
                            <a href="tel:{{ preg_replace('/\s+/', '', $announcement->phone) }}" class="hover:text-primary transition-colors">
                                {{ $announcement->phone }}
                            </a>
                        @else
                            <span class="text-muted-foreground">Téléphone non renseigné</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-primary text-primary-foreground p-4 rounded-lg">
                <div class="text-sm text-primary-foreground/80 mb-1">Prix</div>
                <div class="text-3xl font-bold">{{ $announcement->price }}</div>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-3">Description</h3>
                <p class="text-gray-700 leading-relaxed">{{ $announcement->description }}</p>
            </div>

            <div class="flex items-center gap-4">
                <span class="bg-secondary text-secondary-foreground px-3 py-1 rounded-lg">
                    {{ $announcement->category->name }}
                </span>
                <span class="text-muted-foreground">par {{ $announcement->user->name }}</span>
            </div>

            @auth
                @if(Auth::id() === $announcement->user_id)
                    <div class="flex gap-3 pt-4 border-t">
                        <a href="{{ route('announcements.edit', $announcement) }}" 
                           class="flex-1 bg-primary text-primary-foreground py-2 px-4 rounded-lg hover:bg-primary/90 transition-colors text-center">
                            Modifier
                        </a>
                        <form method="POST" action="{{ route('announcements.destroy', $announcement) }}" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')"
                                    class="w-full bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition-colors">
                                Supprimer
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>

    <!-- Related Announcements -->
    <div class="mt-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Annonces similaires</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach(\App\Models\Announcement::with('media')->where('category_id', $announcement->category_id)->where('id', '!=', $announcement->id)->take(3)->get() as $relatedAnnouncement)
                <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow cursor-pointer border border-border">
                    <div class="aspect-video relative overflow-hidden">
                        <img src="{{ $relatedAnnouncement->image_url }}" 
                             alt="{{ $relatedAnnouncement->title }}"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                    
                    <div class="p-4">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <h3 class="font-medium text-lg line-clamp-1">{{ $relatedAnnouncement->title }}</h3>
                            <p class="text-primary font-semibold whitespace-nowrap">{{ $relatedAnnouncement->price }}</p>
                        </div>
                        
                        <p class="text-muted-foreground line-clamp-2 mb-3">
                            {{ $relatedAnnouncement->description }}
                        </p>
                        
                        <div class="flex items-center justify-between">
                            <span class="bg-secondary text-secondary-foreground px-2 py-1 rounded text-sm">
                                {{ $relatedAnnouncement->category->name }}
                            </span>
                            <a href="{{ route('announcements.show', $relatedAnnouncement) }}" 
                               class="text-primary hover:text-primary/80 text-sm font-medium">
                                Voir plus →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    lucide.createIcons();

    document.addEventListener('DOMContentLoaded', function () {
        const primaryMedia = document.querySelector('[data-primary-media]');
        const triggers = document.querySelectorAll('[data-media-trigger]');

        if (!primaryMedia || !triggers.length) {
            return;
        }

        const updatePrimaryMedia = (type, src, alt) => {
            if (type === 'video') {
                primaryMedia.innerHTML = `<video src="${src}" controls class="w-full h-full object-cover"></video>`;
            } else {
                primaryMedia.innerHTML = `<img src="${src}" alt="${alt}" class="w-full h-full object-cover" loading="lazy">`;
            }
        };

        triggers.forEach((trigger) => {
            trigger.addEventListener('click', () => {
                const type = trigger.dataset.mediaType;
                const src = trigger.dataset.mediaSrc;
                const alt = trigger.dataset.mediaAlt || primaryMedia.dataset.mediaAlt;

                updatePrimaryMedia(type, src, alt);

                triggers.forEach((btn) => btn.classList.remove('ring-2', 'ring-offset-2', 'ring-primary'));
                trigger.classList.add('ring-2', 'ring-offset-2', 'ring-primary');
            });
        });

        const activeTrigger = triggers[0];
        if (activeTrigger) {
            activeTrigger.classList.add('ring-2', 'ring-offset-2', 'ring-primary');
        }
    });
</script>
@endsection

