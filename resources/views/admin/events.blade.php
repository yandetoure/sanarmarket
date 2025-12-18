@extends('layouts.admin')

@section('title', 'Gestion des Événements')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Gestion des Événements</h1>
        <p class="text-gray-600 mt-2">Modérez et gérez tous les événements du campus</p>
    </div>
</div>

<!-- Statistiques -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-teal-100 rounded-lg">
                <i data-lucide="calendar" class="w-6 h-6 text-teal-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Événements</p>
                <p class="text-2xl font-bold text-gray-900">{{ $events->total() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
                <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Approuvés</p>
                <p class="text-2xl font-bold text-gray-900">{{ $events->where('status', 'approved')->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg">
                <i data-lucide="clock" class="w-6 h-6 text-yellow-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">En Attente</p>
                <p class="text-2xl font-bold text-gray-900">{{ $events->where('status', 'pending')->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-red-100 rounded-lg">
                <i data-lucide="x-circle" class="w-6 h-6 text-red-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Rejetés</p>
                <p class="text-2xl font-bold text-gray-900">{{ $events->where('status', 'rejected')->count() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Liste des événements -->
<div class="bg-white rounded-lg shadow-sm border overflow-hidden">
    <div class="px-6 py-4 border-b">
        <h2 class="text-lg font-semibold text-gray-900">Liste des Événements</h2>
    </div>
    
    @if($events->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Événement</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Créateur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lieu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($events as $event)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        @if($event->image)
                                            <img class="h-12 w-12 rounded-lg object-cover" src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}">
                                        @else
                                            <div class="h-12 w-12 rounded-lg bg-teal-100 flex items-center justify-center">
                                                <i data-lucide="calendar" class="w-6 h-6 text-teal-600"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $event->title }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($event->description, 50) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $event->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $event->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $event->start_date->format('d/m/Y') }}</div>
                                @if($event->start_date)
                                    <div class="text-sm text-gray-500">{{ $event->start_date->format('H:i') }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $event->location ?? 'Non spécifié' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($event->status === 'approved') bg-green-100 text-green-800
                                    @elseif($event->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    @if($event->status === 'pending')
                                        <form action="{{ route('admin.events.approve', $event) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900" title="Approuver">
                                                <i data-lucide="check" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.events.reject', $event) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Rejeter">
                                                <i data-lucide="x" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('events.show', $event) }}" class="text-blue-600 hover:text-blue-900" title="Voir">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t">
            {{ $events->links() }}
        </div>
    @else
        <div class="px-6 py-12 text-center">
            <i data-lucide="calendar" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <p class="text-gray-600">Aucun événement trouvé</p>
        </div>
    @endif
</div>

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection

