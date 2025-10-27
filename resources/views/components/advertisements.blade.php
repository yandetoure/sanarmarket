@php
    use App\Models\Advertisement;
    use Carbon\Carbon;
    
    // Récupérer les publicités popup actives
    $popupAds = Advertisement::where('is_active', true)
        ->where('type', 'popup')
        ->where('position', 'popup')
        ->where(function($query) {
            $query->whereNull('start_date')
                  ->orWhere('start_date', '<=', now());
        })
        ->where(function($query) {
            $query->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
        })
        ->get();
@endphp

<!-- Publicités Popup -->
@if($popupAds->count() > 0)
    @foreach($popupAds as $ad)
        <div id="popup-ad-{{ $ad->id }}" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 relative overflow-hidden">
                <!-- Bouton fermer -->
                <button onclick="closePopupAd({{ $ad->id }})" class="absolute top-4 right-4 z-10 bg-white rounded-full p-2 shadow-lg hover:bg-gray-50 transition-colors">
                    <i data-lucide="x" class="w-5 h-5 text-gray-600"></i>
                </button>
                
                <!-- Contenu de la publicité -->
                <div class="p-6">
                    @if($ad->image)
                        <div class="mb-4">
                            <img src="{{ Storage::url($ad->image) }}" alt="{{ $ad->title }}" class="w-full h-48 object-cover rounded-lg">
                        </div>
                    @endif
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $ad->title }}</h3>
                    <p class="text-gray-600 mb-4">{{ $ad->content }}</p>
                    
                    @if($ad->link)
                        <a href="{{ $ad->link }}" target="_blank" class="inline-block bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg font-medium hover:from-blue-700 hover:to-purple-700 transition-all">
                            En savoir plus
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@endif

<script>
    // Fonction pour fermer les popups
    function closePopupAd(adId) {
        const popup = document.getElementById('popup-ad-' + adId);
        if (popup) {
            popup.classList.add('hidden');
            // Stocker dans localStorage que cette pub a été fermée
            localStorage.setItem('popup-ad-closed-' + adId, 'true');
        }
    }
    
    // Afficher les popups après le chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        @if($popupAds->count() > 0)
            @foreach($popupAds as $ad)
                // Vérifier si cette pub n'a pas déjà été fermée
                if (!localStorage.getItem('popup-ad-closed-{{ $ad->id }}')) {
                    setTimeout(function() {
                        const popup = document.getElementById('popup-ad-{{ $ad->id }}');
                        if (popup) {
                            popup.classList.remove('hidden');
                            
                            // Fermer automatiquement après la durée spécifiée
                            @if($ad->popup_duration)
                                setTimeout(function() {
                                    closePopupAd({{ $ad->id }});
                                }, {{ $ad->popup_duration * 1000 }});
                            @endif
                        }
                    }, 1000); // Délai de 1 seconde avant d'afficher
                }
            @endforeach
        @endif
    });
</script>
