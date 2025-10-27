@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-2">Super Admin</h1>
    <p class="text-gray-600 text-lg">Cher {{ Auth::user()->name }}, bienvenue dans votre espace de gestion</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Utilisateurs -->
    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center">
            <div class="p-4 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg">
                <i data-lucide="users" class="w-6 h-6 text-white"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Total Utilisateurs</h3>
                <p class="text-3xl font-bold text-gray-900">{{ $totalUsers }}</p>
                <p class="text-xs text-blue-600 font-medium">{{ \App\Models\User::where('role', 'user')->count() }} utilisateurs, {{ \App\Models\User::where('role', 'admin')->count() }} admins</p>
            </div>
        </div>
    </div>

    <!-- Total Annonces -->
    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center">
            <div class="p-4 bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg">
                <i data-lucide="file-text" class="w-6 h-6 text-white"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Total Annonces</h3>
                <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Announcement::count() }}</p>
                <p class="text-xs text-green-600 font-medium">{{ $activeAnnouncements }} actives</p>
            </div>
        </div>
    </div>

    <!-- Publicités -->
    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center">
            <div class="p-4 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg">
                <i data-lucide="image" class="w-6 h-6 text-white"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Publicités</h3>
                <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Advertisement::count() }}</p>
                <p class="text-xs text-purple-600 font-medium">{{ \App\Models\Advertisement::where('is_active', true)->count() }} actives</p>
            </div>
        </div>
    </div>

    <!-- Catégories -->
    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center">
            <div class="p-4 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-lg">
                <i data-lucide="tag" class="w-6 h-6 text-white"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Catégories</h3>
                <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Category::count() }}</p>
                <p class="text-xs text-orange-600 font-medium">Organisées</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Annonces récentes -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-green-50 to-blue-50">
            <div class="flex items-center">
                <div class="p-2 bg-gradient-to-r from-green-500 to-blue-500 rounded-lg mr-3">
                    <i data-lucide="file-text" class="w-5 h-5 text-white"></i>
                </div>
                <h2 class="text-lg font-semibold text-gray-900">Annonces Récentes</h2>
            </div>
        </div>
        <div class="p-6">
            @if($recentAnnouncements->count() > 0)
                <div class="space-y-4">
                    @foreach($recentAnnouncements as $announcement)
                        <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <img class="h-12 w-12 rounded-xl object-cover shadow-sm" src="{{ $announcement->image_url }}" alt="{{ $announcement->title }}">
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">{{ $announcement->title }}</p>
                                    <p class="text-sm text-gray-500">Par {{ $announcement->user->name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $announcement->status === 'active' ? 'bg-green-100 text-green-800' : ($announcement->status === 'hidden' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ $announcement->status === 'active' ? 'Active' : ($announcement->status === 'hidden' ? 'Masquée' : 'En attente') }}
                                </span>
                                <p class="text-xs text-gray-500 mt-1">{{ $announcement->formatted_date }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.announcements') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                        Voir toutes les annonces 
                        <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-8">
                    <i data-lucide="file-text" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                    <p class="text-gray-500">Aucune annonce récente</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Utilisateurs récents -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-purple-50">
            <div class="flex items-center">
                <div class="p-2 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg mr-3">
                    <i data-lucide="users" class="w-5 h-5 text-white"></i>
                </div>
                <h2 class="text-lg font-semibold text-gray-900">Utilisateurs Récents</h2>
            </div>
        </div>
        <div class="p-6">
            @if($recentUsers->count() > 0)
                <div class="space-y-4">
                    @foreach($recentUsers as $user)
                        <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <div class="h-12 w-12 bg-gradient-to-r from-gray-200 to-gray-300 rounded-full flex items-center justify-center shadow-sm">
                                    <i data-lucide="user" class="w-6 h-6 text-gray-600"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $user->role === 'admin' ? 'Admin' : 'Utilisateur' }}
                                </span>
                                <p class="text-xs text-gray-500 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.users') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                        Voir tous les utilisateurs 
                        <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-8">
                    <i data-lucide="users" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                    <p class="text-gray-500">Aucun utilisateur récent</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection