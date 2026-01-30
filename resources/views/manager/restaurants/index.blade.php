@extends('layouts.dashboard')

@section('content')
    <div class="space-y-12">
        <!-- Premium List Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 pb-4" data-aos="fade-down">
            <div class="space-y-2">
                <div class="flex items-center space-x-3 mb-2">
                    <span class="px-3 py-1 rounded-full bg-orange-50 text-orange-600 text-[10px] font-black uppercase tracking-widest border border-orange-100">Gastronomie</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Ma Cuisine</span>
                </div>
                <h1 class="text-4xl font-display font-black text-slate-900 leading-tight">
                    Mes <span class="text-gradient">Restaurants</span>
                </h1>
                <p class="text-slate-500 font-medium max-w-lg">Gérez vos menus, configurez vos horaires d'ouverture et enchantez les papilles des étudiants du campus.</p>
            </div>
            <div class="flex items-center space-x-4">
                <x-button href="{{ route('restaurants.create') }}" variant="primary" size="lg"
                    class="rounded-2xl shadow-2xl shadow-primary-500/25 py-5 px-8 group bg-slate-900 border-none hover:bg-slate-800">
                    <svg class="w-5 h-5 mr-3 group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Ajouter un restaurant</span>
                </x-button>
            </div>
        </div>

        @if($restaurants->isEmpty())
            <!-- Cinematic Empty State -->
            <div class="col-span-full py-40 text-center glass rounded-[4rem] border-white shadow-2xl" data-aos="zoom-in">
                <div class="w-32 h-32 bg-slate-50 rounded-[3rem] flex items-center justify-center mx-auto mb-10 shadow-inner group relative">
                    <div class="absolute inset-0 bg-orange-100 rounded-[3rem] group-hover:scale-125 opacity-0 group-hover:opacity-50 blur-2xl transition-all duration-700"></div>
                    <svg class="w-16 h-16 text-slate-300 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-3xl font-display font-black text-slate-900 mb-4">Prêt à régaler le campus ?</h3>
                <p class="text-slate-400 font-medium mb-12 max-w-sm mx-auto leading-relaxed">Ouvrez votre cuisine digitale sur SanarWeb et atteignez des milliers d'étudiants affamés en quelques instants.</p>
                <x-button href="{{ route('restaurants.create') }}" variant="primary" size="lg"
                    class="rounded-3xl shadow-2xl shadow-orange-500/30 px-12 py-6 bg-orange-600 border-none hover:bg-orange-700">
                    Ouvrir mon restaurant
                </x-button>
            </div>
        @else
            <!-- Premium Restaurant Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($restaurants as $index => $restaurant)
                    <div class="glass rounded-[3.5rem] border-white shadow-2xl shadow-slate-200/40 p-10 group hover:-translate-y-3 transition-all duration-700 relative overflow-hidden"
                        data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">

                        <!-- Status Decorative Background -->
                        <div class="absolute top-0 right-0 w-32 h-32 {{ $restaurant->status === 'approved' ? 'bg-orange-50' : 'bg-blue-50' }} rounded-full -mr-16 -mt-16 blur-3xl opacity-50 transition-colors"></div>

                        <div class="relative z-10 space-y-8">
                            <div class="flex items-center justify-between">
                                <div class="w-16 h-16 bg-white rounded-[1.5rem] shadow-xl shadow-slate-200/50 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-500">
                                    🍳
                                </div>
                                <div class="glass-light px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $restaurant->status === 'approved' ? 'text-emerald-600' : 'text-blue-500' }}">
                                    {{ $restaurant->status === 'approved' ? 'En Service' : 'Validation' }}
                                </div>
                            </div>

                            <div>
                                <h3 class="text-2xl font-display font-black text-slate-900 group-hover:text-primary-600 transition-colors">{{ $restaurant->name }}</h3>
                                <div class="flex items-center space-x-3 mt-2 text-slate-400">
                                    <span class="text-[10px] font-bold uppercase tracking-widest">{{ $restaurant->menu_items_count }} Plats</span>
                                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                    <span class="text-[10px] font-bold uppercase tracking-widest">{{ $restaurant->schedules_count ?? 0 }} Horaires</span>
                                </div>
                            </div>

                            @if($restaurant->address)
                                <div class="flex items-center space-x-2 text-slate-500 text-sm font-medium">
                                    <span class="text-slate-400">📍</span>
                                    <span class="truncate">{{ $restaurant->address }}</span>
                                </div>
                            @endif

                            <div class="pt-6 border-t border-slate-50 grid grid-cols-2 gap-4">
                                <x-button href="{{ route('restaurants.manage', $restaurant) }}" variant="primary" size="sm"
                                    class="rounded-2xl shadow-xl shadow-slate-900/10 py-4 font-black text-[10px] uppercase tracking-widest">
                                    Gestion
                                </x-button>
                                <x-button href="{{ route('restaurants.public.show', $restaurant->slug) }}" variant="secondary" size="sm"
                                    class="rounded-2xl border-slate-100 hover:bg-slate-50 py-4 font-black text-[10px] uppercase tracking-widest">
                                    Aperçu
                                </x-button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Enhanced Pagination -->
            @if($restaurants->hasPages())
                <div class="mt-20 flex justify-center">
                    {{ $restaurants->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection
