@extends('layouts.dashboard')

@section('content')
    <div class="space-y-12">
        <!-- Premium List Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 pb-4" data-aos="fade-down">
            <div class="space-y-2">
                <div class="flex items-center space-x-3 mb-2">
                    <span
                        class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest border border-emerald-100">Commerce</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Ma Franchise</span>
                </div>
                <h1 class="text-4xl font-display font-black text-slate-900 leading-tight">
                    Mes <span class="text-gradient">Boutiques</span>
                </h1>
                <p class="text-slate-500 font-medium max-w-lg">Gérez vos points de vente, suivez vos stocks et développez
                    votre présence sur le campus.</p>
            </div>
            <div class="flex items-center space-x-4">
                <x-button href="{{ route('boutiques.create') }}" variant="primary" size="lg"
                    class="rounded-2xl shadow-2xl shadow-primary-500/25 py-5 px-8 group bg-slate-900 border-none hover:bg-slate-800">
                    <svg class="w-5 h-5 mr-3 group-hover:rotate-90 transition-transform duration-500" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Ajouter une boutique</span>
                </x-button>
            </div>
        </div>

        @if($boutiques->isEmpty())
            <!-- Cinematic Empty State -->
            <div class="col-span-full py-40 text-center glass rounded-[4rem] border-white shadow-2xl" data-aos="zoom-in">
                <div
                    class="w-32 h-32 bg-slate-50 rounded-[3rem] flex items-center justify-center mx-auto mb-10 shadow-inner group relative">
                    <div
                        class="absolute inset-0 bg-emerald-100 rounded-[3rem] group-hover:scale-125 opacity-0 group-hover:opacity-50 blur-2xl transition-all duration-700">
                    </div>
                    <svg class="w-16 h-16 text-slate-300 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h3 class="text-3xl font-display font-black text-slate-900 mb-4">Prêt à lancer votre boutique ?</h3>
                <p class="text-slate-400 font-medium mb-12 max-w-sm mx-auto leading-relaxed">Devenez un vendeur de référence sur
                    SanarWeb et commencez à digitaliser votre commerce dès aujourd'hui.</p>
                <x-button href="{{ route('boutiques.create') }}" variant="primary" size="lg"
                    class="rounded-3xl shadow-2xl shadow-emerald-500/30 px-12 py-6 bg-emerald-600 border-none hover:bg-emerald-700">
                    Lancer ma boutique
                </x-button>
            </div>
        @else
            <!-- Premium Boutique Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($boutiques as $index => $boutique)
                    <div class="glass rounded-[3.5rem] border-white shadow-2xl shadow-slate-200/40 p-10 group hover:-translate-y-3 transition-all duration-700 relative overflow-hidden"
                        data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">

                        <!-- Status Decorative Background -->
                        <div
                            class="absolute top-0 right-0 w-32 h-32 {{ $boutique->status === 'approved' ? 'bg-emerald-50' : 'bg-orange-50' }} rounded-full -mr-16 -mt-16 blur-3xl opacity-50 transition-colors">
                        </div>

                        <div class="relative z-10 space-y-8">
                            <div class="flex items-center justify-between">
                                <div
                                    class="w-16 h-16 bg-white rounded-[1.5rem] shadow-xl shadow-slate-200/50 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-500">
                                    🏪
                                </div>
                                <div
                                    class="glass-light px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $boutique->status === 'approved' ? 'text-emerald-600' : 'text-orange-500' }}">
                                    {{ $boutique->status === 'approved' ? 'Opérationnelle' : 'En attente' }}
                                </div>
                            </div>

                            <div>
                                <h3
                                    class="text-2xl font-display font-black text-slate-900 group-hover:text-primary-600 transition-colors">
                                    {{ $boutique->name }}</h3>
                                <div class="flex items-center space-x-3 mt-2 text-slate-400">
                                    <span class="text-[10px] font-bold uppercase tracking-widest">{{ $boutique->articles_count }}
                                        Articles</span>
                                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                    <span class="text-[10px] font-bold uppercase tracking-widest">{{ $boutique->categories_count }}
                                        Catégories</span>
                                </div>
                            </div>

                            @if($boutique->address)
                                <div class="flex items-center space-x-2 text-slate-500 text-sm font-medium">
                                    <span class="text-slate-400">📍</span>
                                    <span class="truncate">{{ $boutique->address }}</span>
                                </div>
                            @endif

                            <div class="pt-6 border-t border-slate-50 grid grid-cols-2 gap-4">
                                <x-button href="{{ route('boutiques.manage', $boutique) }}" variant="primary" size="sm"
                                    class="rounded-2xl shadow-xl shadow-slate-900/10 py-4 font-black text-[10px] uppercase tracking-widest">
                                    Gérer Hub
                                </x-button>
                                <x-button href="{{ route('boutiques.public.show', $boutique->slug) }}" variant="secondary" size="sm"
                                    class="rounded-2xl border-slate-100 hover:bg-slate-50 py-4 font-black text-[10px] uppercase tracking-widest">
                                    Aperçu
                                </x-button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Enhanced Pagination -->
            @if($boutiques->hasPages())
                <div class="mt-20 flex justify-center">
                    {{ $boutiques->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection