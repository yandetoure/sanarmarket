@extends('layouts.app')

@section('title', 'Détails de la Publicité - Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $advertisement->title }}</h1>
                    <p class="text-gray-600 mt-2">{{ $advertisement->content }}</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.advertisements.edit', $advertisement) }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors flex items-center gap-2">
                        <i data-lucide="edit" class="w-4 h-4"></i>
                        Modifier
                    </a>
                    <a href="{{ route('admin.advertisements.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                        Retour
                    </a>
                </div>
            </div>
        </div>

        <!-- Informations de la publicité -->
        <div class="bg-white rounded-lg shadow-sm border p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Informations</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                    <p class="text-gray-900">{{ $advertisement->title }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $advertisement->type === 'popup' ? 'bg-orange-100 text-orange-800' : 'bg-purple-100 text-purple-800' }}">
                        {{ $advertisement->type === 'popup' ? 'Popup' : 'Bannière' }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Position</label>
                    <p class="text-gray-900">{{ $advertisement->position === 'hero' ? 'Section Hero' : 'Popup' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Durée d'affichage</label>
                    <p class="text-gray-900">{{ $advertisement->formatted_duration }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $advertisement->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $advertisement->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lien</label>
                    @if($advertisement->link)
                        <a href="{{ $advertisement->link }}" target="_blank" class="text-purple-600 hover:text-purple-800">{{ $advertisement->link }}</a>
                    @else
                        <p class="text-gray-500">Aucun lien</p>
                    @endif
                </div>
                @if($advertisement->start_date)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                    <p class="text-gray-900">{{ $advertisement->start_date->format('d/m/Y H:i') }}</p>
                </div>
                @endif
                @if($advertisement->end_date)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                    <p class="text-gray-900">{{ $advertisement->end_date->format('d/m/Y H:i') }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Image -->
        @if($advertisement->image)
        <div class="bg-white rounded-lg shadow-sm border p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Image</h2>
            <img src="{{ $advertisement->image_url }}" alt="{{ $advertisement->title }}" class="max-w-md rounded-lg">
        </div>
        @endif

        <!-- Contenu -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Contenu</h2>
            <div class="prose max-w-none">
                <p class="text-gray-700">{{ $advertisement->content }}</p>
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection







