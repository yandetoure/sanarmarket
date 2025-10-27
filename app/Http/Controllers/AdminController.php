<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()?->isAdmin()) {
                abort(403, 'Accès non autorisé');
            }
            return $next($request);
        });
    }

    /**
     * Dashboard admin
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalAnnouncements = Announcement::count();
        $activeAnnouncements = Announcement::active()->count();
        $hiddenAnnouncements = Announcement::where('status', 'hidden')->count();
        $pendingAnnouncements = Announcement::where('status', 'pending')->count();
        
        $recentAnnouncements = Announcement::with(['user', 'category'])
            ->latest()
            ->take(10)
            ->get();
            
        $recentUsers = User::latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAnnouncements', 
            'activeAnnouncements',
            'hiddenAnnouncements',
            'pendingAnnouncements',
            'recentAnnouncements',
            'recentUsers'
        ));
    }

    /**
     * Liste des utilisateurs
     */
    public function users()
    {
        $users = User::withCount('announcements')->paginate(20);
        return view('admin.users', compact('users'));
    }

    /**
     * Activer/Désactiver un utilisateur
     */
    public function toggleUserStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        
        $status = $user->is_active ? 'activé' : 'désactivé';
        return redirect()->back()->with('success', "Utilisateur {$status} avec succès !");
    }

    /**
     * Changer le rôle d'un utilisateur
     */
    public function changeUserRole(User $user, Request $request)
    {
        $request->validate([
            'role' => 'required|in:user,admin'
        ]);
        
        $user->update(['role' => $request->role]);
        
        return redirect()->back()->with('success', "Rôle de l'utilisateur modifié avec succès !");
    }

    /**
     * Liste des annonces pour l'admin
     */
    public function announcements()
    {
        $announcements = Announcement::with(['user', 'category'])
            ->latest()
            ->paginate(20);
            
        return view('admin.announcements', compact('announcements'));
    }

    /**
     * Masquer une annonce
     */
    public function hideAnnouncement(Announcement $announcement)
    {
        $announcement->update(['status' => 'hidden']);
        
        return redirect()->back()->with('success', 'Annonce masquée avec succès !');
    }

    /**
     * Activer une annonce
     */
    public function activateAnnouncement(Announcement $announcement)
    {
        $announcement->update(['status' => 'active']);
        
        return redirect()->back()->with('success', 'Annonce activée avec succès !');
    }

    /**
     * Mettre en attente une annonce
     */
    public function pendingAnnouncement(Announcement $announcement)
    {
        $announcement->update(['status' => 'pending']);
        
        return redirect()->back()->with('success', 'Annonce mise en attente avec succès !');
    }
}