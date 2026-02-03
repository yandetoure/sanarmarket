@extends('layouts.dashboard')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-display font-black text-slate-900">Gestion des Événements</h1>
                <p class="text-slate-500 mt-1">Tous les événements universitaires</p>
            </div>
            <a href="{{ route('admin.events.create') }}"
                class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transition-all">
                + Nouvel Événement
            </a>
        </div>

        <!-- Events List -->
        <div class="glass rounded-3xl border border-white shadow-2xl overflow-hidden">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Événement
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">
                            Organisateur</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Lieu</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Statut
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-black text-slate-600 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($events as $event)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($event->image_url)
                                        <img src="{{ $event->image_url }}" class="w-12 h-12 rounded-lg object-cover mr-3">
                                    @endif
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $event->title }}</p>
                                        <p class="text-xs text-slate-500">{{ Str::limit($event->description, 50) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="font-semibold text-slate-700">{{ $event->user->name }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="font-bold text-slate-900">
                                    {{ $event->start_date ? $event->start_date->format('d/m/Y') : '-' }}</p>
                                <p class="text-xs text-slate-500">
                                    {{ $event->start_date ? $event->start_date->format('H:i') : '' }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                {{ $event->location }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($event->isApproved())
                                    <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-bold">Validé</span>
                                @elseif($event->isRejected())
                                    <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-bold">Rejeté</span>
                                @else
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-bold">En
                                        attente</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.events.edit', $event) }}"
                                        class="btn btn-sm btn-ghost btn-circle text-slate-500 hover:text-indigo-600 hover:bg-indigo-50" title="Modifier">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00 2 2h11a2 2 0 00 2-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    @if(!$event->isApproved())
                                        <form action="{{ route('admin.events.approve', $event) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-ghost btn-circle text-green-500 hover:text-green-700 hover:bg-green-50" title="Approuver">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.events.reject', $event) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-ghost btn-circle text-red-500 hover:text-red-700 hover:bg-red-50" title="Rejeter">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-slate-300 px-2">-</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                Aucun événement trouvé
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $events->links() }}
        </div>
    </div>
@endsection