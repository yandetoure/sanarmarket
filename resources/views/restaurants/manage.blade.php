@extends('layouts.dashboard')

@section('title', 'Gestion Restaurant - ' . $restaurant->name)

@section('content')
    <div class="space-y-10" x-data="{ currentTab: 'overview' }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6" data-aos="fade-down">
            <div class="flex items-center space-x-4">
                <div
                    class="w-16 h-16 rounded-[2rem] bg-gradient-to-br from-orange-500 to-red-600 flex items-center justify-center text-white font-display font-black text-2xl shadow-lg shadow-orange-100">
                    {{ strtoupper(substr($restaurant->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-3xl font-display font-black text-slate-900 leading-tight">{{ $restaurant->name }}</h1>
                    <div class="flex items-center space-x-3 mt-1">
                        <x-badge variant="{{ $restaurant->status === 'active' ? 'emerald' : 'orange' }}" size="sm">
                            {{ ucfirst($restaurant->status) }}
                        </x-badge>
                        <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Restaurant ID:
                            #{{ $restaurant->id }}</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <x-button href="{{ route('restaurants.show', $restaurant) }}" variant="secondary" size="md">Aperçu
                    Public</x-button>
                <x-button href="{{ route('restaurants.edit', $restaurant) }}" variant="primary"
                    size="md">Paramètres</x-button>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6" data-aos="fade-up">
            <div class="glass-light p-8 rounded-[2.5rem] border-white/60 shadow-lg shadow-slate-100/50">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Plats au Menu</p>
                <p class="text-3xl font-display font-black text-slate-900">{{ $restaurant->menu_items_count }}</p>
            </div>
            <div class="glass-light p-8 rounded-[2.5rem] border-white/60 shadow-lg shadow-orange-50/50">
                <p class="text-[10px] font-black text-orange-500 uppercase tracking-widest mb-1">Horaires</p>
                <p class="text-3xl font-display font-black text-slate-900">{{ $restaurant->schedules_count }}</p>
            </div>
            <div class="glass-light p-8 rounded-[2.5rem] border-white/60 shadow-lg shadow-primary-50/50">
                <p class="text-[10px] font-black text-primary-500 uppercase tracking-widest mb-1">Commandes</p>
                <p class="text-3xl font-display font-black text-slate-900">--</p>
            </div>
            <div
                class="glass-light p-8 rounded-[2.5rem] border-white/60 shadow-lg shadow-slate-100/50 bg-gradient-to-br from-white to-slate-50">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Avis</p>
                <p class="text-3xl font-display font-black text-slate-900">--</p>
            </div>
        </div>

        <!-- Management Console -->
        <div class="glass rounded-[3rem] border-white/60 shadow-2xl shadow-slate-200/50 overflow-hidden" data-aos="fade-up"
            data-aos-delay="100">
            <!-- Tabs Nav -->
            <div class="flex border-b border-slate-100 bg-slate-50/50 backdrop-blur-md sticky top-0 z-10 px-6">
                <button @click="currentTab = 'overview'"
                    :class="currentTab === 'overview' ? 'text-primary-600 border-primary-600' : 'text-slate-400 border-transparent'"
                    class="px-8 py-6 text-sm font-black uppercase tracking-widest border-b-2 transition-all">Overview</button>
                <button @click="currentTab = 'menu'"
                    :class="currentTab === 'menu' ? 'text-primary-600 border-primary-600' : 'text-slate-400 border-transparent'"
                    class="px-8 py-6 text-sm font-black uppercase tracking-widest border-b-2 transition-all">Menu</button>
                <button @click="currentTab = 'schedules'"
                    :class="currentTab === 'schedules' ? 'text-primary-600 border-primary-600' : 'text-slate-400 border-transparent'"
                    class="px-8 py-6 text-sm font-black uppercase tracking-widest border-b-2 transition-all">Horaires</button>
            </div>

            <div class="p-10">
                <!-- Overview Tab -->
                <div x-show="currentTab === 'overview'" class="space-y-10 animate-fade-in">
                    <div class="grid md:grid-cols-2 gap-12">
                        <div class="space-y-6">
                            <h3 class="text-xl font-display font-black text-slate-900">Infos Établissement</h3>
                            <div class="space-y-4">
                                <div
                                    class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                    <span
                                        class="text-xs font-bold text-slate-400 uppercase tracking-widest">Téléphone</span>
                                    <span class="text-sm font-black text-slate-900">{{ $restaurant->phone ?? 'NR' }}</span>
                                </div>
                                <div
                                    class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Cuisine</span>
                                    <span
                                        class="text-sm font-black text-slate-900">{{ $restaurant->metadata['cuisine_type'] ?? 'Standard' }}</span>
                                </div>
                                <div
                                    class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Gamme de
                                        Prix</span>
                                    <span
                                        class="text-sm font-black text-slate-900">{{ $restaurant->metadata['price_range'] ?? '$$' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <h3 class="text-xl font-display font-black text-slate-900">À propos</h3>
                            <p
                                class="text-sm text-slate-600 font-medium leading-relaxed bg-white p-6 rounded-[2rem] border border-slate-100 italic">
                                {{ $restaurant->description ?? 'Aucune description fournie.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Menu Tab -->
                <div x-show="currentTab === 'menu'" class="animate-fade-in">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xl font-display font-black text-slate-900">La Carte</h3>
                        <x-button href="{{ route('restaurants.menu-items.create', $restaurant) }}" variant="primary"
                            size="sm">+ Ajouter Plat</x-button>
                    </div>

                    <div class="overflow-x-auto -mx-10">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50">
                                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Plat
                                    </th>
                                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Prix
                                    </th>
                                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Status
                                    </th>
                                    <th
                                        class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($restaurant->menuItems as $item)
                                    <tr class="hover:bg-slate-50/50 transition-colors group">
                                        <td class="p-6">
                                            <div class="flex items-center space-x-4">
                                                <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden shadow-sm">
                                                    @if($item->image)
                                                        <img src="{{ storage_url($item->image) }}"
                                                            class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                                <path
                                                                    d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <span
                                                    class="text-sm font-black text-slate-900 group-hover:text-primary-600 transition-colors">{{ $item->title }}</span>
                                            </div>
                                        </td>
                                        <td class="p-6"><span
                                                class="text-sm font-black text-slate-900">{{ number_format($item->price, 0, ',', ' ') }}
                                                FCFA</span></td>
                                        <td class="p-6">
                                            @if($item->is_available)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-lg bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest">Disponible</span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-lg bg-red-50 text-red-600 text-[10px] font-black uppercase tracking-widest">Épuisé</span>
                                            @endif
                                        </td>
                                        <td class="p-6 text-right">
                                            <div class="flex items-center justify-end space-x-2">
                                                <x-button variant="ghost" size="xs"
                                                    class="hover:bg-white shadow-sm border border-slate-100">Modifier</x-button>
                                                <form action="#" method="POST" onsubmit="return confirm('Supprimer ce plat ?')">
                                                    @csrf @method('DELETE')
                                                    <x-button type="submit" variant="ghost" size="xs"
                                                        class="text-red-500 hover:bg-red-50">×</x-button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Schedules Tab -->
                <div x-show="currentTab === 'schedules'" class="animate-fade-in">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xl font-display font-black text-slate-900">Horaires d'Ouverture</h3>
                        <x-button href="{{ route('restaurants.schedules.create', $restaurant) }}" variant="primary"
                            size="sm">+ Configurer Horaires</x-button>
                    </div>

                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @php $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']; @endphp
                        @foreach($restaurant->schedules as $schedule)
                            <div
                                class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm group hover:border-orange-200 transition-all">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">
                                    {{ $days[$schedule->day_of_week] ?? 'Jour' }}</p>
                                @if($schedule->is_closed)
                                    <p class="text-lg font-display font-black text-red-500">Fermé</p>
                                @else
                                    <p class="text-lg font-display font-black text-slate-900">{{ $schedule->opens_at }} -
                                        {{ $schedule->closes_at }}</p>
                                @endif
                                <div class="mt-6 flex items-center space-x-2">
                                    <x-button variant="ghost" size="xs" class="flex-1 bg-slate-50">Edit</x-button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection