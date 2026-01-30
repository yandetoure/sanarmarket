@extends('layouts.designer')

@section('title', 'Mes Créations')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Mes Créations</h1>
            <p class="text-gray-600 mt-2">Gérez vos publicités créées</p>
        </div>
        <a href="{{ route('designer.create') }}" class="bg-gradient-to-r from-pink-600 to-purple-600 text-white px-4 py-2 rounded-lg hover:from-pink-700 hover:to-purple-700 transition-all flex items-center gap-2 shadow-md">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Nouvelle publicité
        </a>
    </div>
</div>

@if($advertisements->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($advertisements as $ad)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow">
                @if($ad->image)
                    <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-pink-100 to-purple-100 flex items-center justify-center">
                        <i data-lucide="image" class="w-16 h-16 text-gray-400"></i>
                    </div>
                @endif
                
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $ad->title }}</h3>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $ad->description }}</p>
                    
                    <div class="flex items-center justify-between">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $ad->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $ad->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <a href="{{ route('designer.edit', $ad) }}" class="text-pink-600 hover:text-pink-800 text-sm font-medium">
                            Modifier →
                        </a>
                    </div>
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
        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune création</h3>
        <p class="text-gray-600 mb-6">Commencez par créer votre première publicité</p>
        <a href="{{ route('designer.create') }}" class="inline-flex bg-gradient-to-r from-pink-600 to-purple-600 text-white px-6 py-3 rounded-lg hover:from-pink-700 hover:to-purple-700 transition-all shadow-md">
            <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
            Créer une publicité
        </a>
    </div>
@endif

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection
@endsection

