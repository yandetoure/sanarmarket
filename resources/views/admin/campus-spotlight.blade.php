@extends('layouts.admin')

@section('title', 'Gestion À la une au campus')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Gestion À la une au campus</h1>
        <p class="text-gray-600 mt-2">Gérez les informations importantes du campus</p>
    </div>
</div>

<!-- Statistiques -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-violet-100 rounded-lg">
                <i data-lucide="megaphone" class="w-6 h-6 text-violet-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Informations</p>
                <p class="text-2xl font-bold text-gray-900">{{ $spotlights->total() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
                <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Actives</p>
                <p class="text-2xl font-bold text-gray-900">{{ $spotlights->where('is_active', true)->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-gray-100 rounded-lg">
                <i data-lucide="eye-off" class="w-6 h-6 text-gray-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Inactives</p>
                <p class="text-2xl font-bold text-gray-900">{{ $spotlights->where('is_active', false)->count() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Liste des informations -->
<div class="bg-white rounded-lg shadow-sm border overflow-hidden">
    <div class="px-6 py-4 border-b">
        <h2 class="text-lg font-semibold text-gray-900">Liste des Informations</h2>
    </div>
    
    @if($spotlights->count() > 0)
        <div class="divide-y divide-gray-200">
            @foreach($spotlights as $spotlight)
                <div class="px-6 py-4 hover:bg-gray-50">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $spotlight->title }}</h3>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $spotlight->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $spotlight->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">{{ $spotlight->content }}</p>
                            <div class="flex items-center gap-4 text-xs text-gray-500">
                                <span><i data-lucide="user" class="w-3 h-3 inline"></i> {{ $spotlight->user->name }}</span>
                                <span><i data-lucide="calendar" class="w-3 h-3 inline"></i> {{ $spotlight->published_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <form action="{{ route('admin.campus-spotlight.toggle', $spotlight) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-indigo-600 hover:text-indigo-900" title="{{ $spotlight->is_active ? 'Désactiver' : 'Activer' }}">
                                    <i data-lucide="{{ $spotlight->is_active ? 'eye-off' : 'eye' }}" class="w-5 h-5"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="px-6 py-4 border-t">
            {{ $spotlights->links() }}
        </div>
    @else
        <div class="px-6 py-12 text-center">
            <i data-lucide="megaphone" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <p class="text-gray-600">Aucune information à la une trouvée</p>
        </div>
    @endif
</div>
@endsection
@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection

