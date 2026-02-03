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
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('admin.events.edit', $event) }}"
                                    class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                @if(!$event->isApproved())
                                    <form action="{{ route('admin.events.approve', $event) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900">Approuver</button>
                                    </form>
                                    <form action="{{ route('admin.events.reject', $event) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900">Rejeter</button>
                                    </form>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
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