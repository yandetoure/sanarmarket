@extends('layouts.marketing')

@section('title', 'Gestion des Publicités')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Gestion des Publicités</h1>
    <p class="text-gray-600 mt-2">Activez ou désactivez les publicités</p>
</div>

@if($advertisements->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($advertisements as $ad)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow">
                @if($ad->image)
                    <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-green-100 to-purple-100 flex items-center justify-center">
                        <i data-lucide="image" class="w-16 h-16 text-gray-400"></i>
                    </div>
                @endif
                
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $ad->title }}</h3>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $ad->description }}</p>
                    
                    <div class="flex items-center justify-between mb-3">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $ad->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $ad->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        @if($ad->designer)
                            <span class="text-xs text-gray-500">Par {{ $ad->designer->name }}</span>
                        @endif
                    </div>
                    
                    <form method="POST" action="{{ route('marketing.advertisements.toggle', $ad) }}" class="inline w-full">
                        @csrf
                        <button type="submit" class="w-full text-center {{ $ad->is_active ? 'bg-red-50 text-red-700 hover:bg-red-100' : 'bg-green-50 text-green-700 hover:bg-green-100' }} px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            {{ $ad->is_active ? 'Désactiver' : 'Activer' }}
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-6">
        {{ $advertisements->links() }}
    </div>
@else
    <div class="bg-white rounded-lg shadow-sm border p-12 text-center">
        <i data-lucide="image" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune publicité</h3>
        <p class="text-gray-600">Il n'y a pas de publicités pour le moment</p>
    </div>
@endif

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection
@endsection

