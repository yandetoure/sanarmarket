@extends('layouts.dashboard')

@section('content')
    <div class="space-y-12">
        <!-- Ambassador Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 pb-4" data-aos="fade-down">
            <div class="space-y-2">
                <div class="flex items-center space-x-3 mb-2">
                    <span
                        class="px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest border border-blue-100">Ambassadeur</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Centre de Validation</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-display font-black text-slate-900 leading-tight">
                    Supervision du <br>
                    <span class="text-gradient">Commerce Campus</span> 🛡️
                </h1>
            </div>
        </div>

        <!-- Metrics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="glass p-8 rounded-[2.5rem] border-white shadow-2xl shadow-slate-200/50 group" data-aos="fade-up">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600">
                        🏪
                    </div>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Boutiques Attente</p>
                <h4 class="text-3xl font-display font-black text-slate-900">{{ $stats['pending_boutiques'] }}</h4>
            </div>

            <div class="glass p-8 rounded-[2.5rem] border-white shadow-2xl shadow-slate-200/50 group" data-aos="fade-up"
                data-aos-delay="100">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600">
                        🍽️
                    </div>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Restos Attente</p>
                <h4 class="text-3xl font-display font-black text-slate-900">{{ $stats['pending_restaurants'] }}</h4>
            </div>

            <div class="glass p-8 rounded-[2.5rem] border-white shadow-2xl shadow-slate-200/50 group" data-aos="fade-up"
                data-aos-delay="200">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600">
                        ✅
                    </div>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Boutiques Approuvées</p>
                <h4 class="text-3xl font-display font-black text-slate-900">{{ $stats['approved_boutiques'] }}</h4>
            </div>

            <div class="glass p-8 rounded-[2.5rem] border-white shadow-2xl shadow-slate-200/50 group" data-aos="fade-up"
                data-aos-delay="300">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600">
                        🍴
                    </div>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Restos Approuvés</p>
                <h4 class="text-3xl font-display font-black text-slate-900">{{ $stats['approved_restaurants'] }}</h4>
            </div>
        </div>

        <!-- Validation Queues -->
        <div class="grid lg:grid-cols-2 gap-10">
            <!-- Pending Boutiques -->
            <div class="glass rounded-[3rem] border-white shadow-2xl overflow-hidden" data-aos="fade-right">
                <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                    <h3 class="text-xl font-display font-black">Boutiques à Valider</h3>
                    <a href="{{ route('ambassador.boutiques.pending') }}"
                        class="text-xs font-bold text-primary-600 uppercase tracking-widest underline">Tout voir</a>
                </div>
                <div class="divide-y divide-slate-50">
                    @forelse($recent_boutiques->where('validation_status', 'pending') as $boutique)
                        <div class="p-6 flex items-center justify-between group hover:bg-slate-50/50">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-xl">
                                    🏪
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900">{{ $boutique->name }}</p>
                                    <p class="text-xs text-slate-400">Par {{ $boutique->user->name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <form action="{{ route('ambassador.boutiques.approve', $boutique) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="p-2 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-600 hover:text-white transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                </form>
                                <form action="{{ route('ambassador.boutiques.reject', $boutique) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-slate-400 italic">Aucune boutique en attente.</div>
                    @endforelse
                </div>
            </div>

            <!-- Pending Restaurants -->
            <div class="glass rounded-[3rem] border-white shadow-2xl overflow-hidden" data-aos="fade-left">
                <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                    <h3 class="text-xl font-display font-black">Restaurants à Valider</h3>
                    <a href="{{ route('ambassador.restaurants.pending') }}"
                        class="text-xs font-bold text-primary-600 uppercase tracking-widest underline">Tout voir</a>
                </div>
                <div class="divide-y divide-slate-50">
                    @forelse($recent_restaurants->where('validation_status', 'pending') as $restaurant)
                        <div class="p-6 flex items-center justify-between group hover:bg-slate-50/50">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-xl">
                                    🍽️
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900">{{ $restaurant->name }}</p>
                                    <p class="text-xs text-slate-400">Par {{ $restaurant->user->name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <form action="{{ route('ambassador.restaurants.approve', $restaurant) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="p-2 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-600 hover:text-white transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                </form>
                                <form action="{{ route('ambassador.restaurants.reject', $restaurant) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-slate-400 italic">Aucun restaurant en attente.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection