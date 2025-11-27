<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
        
        $recentAnnouncements = Announcement::with(['user', 'category', 'media'])
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
            'role' => 'required|in:user,premium,admin,designer,marketing'
        ]);
        
        $user->update(['role' => $request->role]);
        
        return redirect()->back()->with('success', "Rôle de l'utilisateur modifié avec succès !");
    }

    /**
     * Basculer un utilisateur en Premium/Standard
     */
    public function toggleUserPremium(User $user)
    {
        // Ne pas déclasser les rôles spéciaux (admin/designer/marketing) automatiquement
        if (!in_array($user->role, [User::ROLE_USER, User::ROLE_PREMIUM], true)) {
            return redirect()->back()->withErrors([
                'premium' => "Impossible de modifier le statut premium pour les rôles {$user->role}.",
            ]);
        }

        $newRole = $user->role === User::ROLE_PREMIUM
            ? User::ROLE_USER
            : User::ROLE_PREMIUM;

        $user->update(['role' => $newRole]);

        $label = $newRole === User::ROLE_PREMIUM ? 'Premium' : 'Standard';

        return redirect()->back()->with('success', "Le compte a été marqué {$label}.");
    }

    /**
     * Afficher le formulaire de création d'utilisateur
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Créer un nouvel utilisateur
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,premium,admin,designer,marketing',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['is_active'] = $request->has('is_active') ? true : false;

        User::create($validated);

        return redirect()->route('admin.users')->with('success', 'Utilisateur créé avec succès !');
    }

    /**
     * Liste des annonces pour l'admin
     */
    public function announcements()
    {
        $announcements = Announcement::with(['user', 'category', 'media'])
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

    /**
     * Afficher le formulaire de modification du profil
     */
    public function editProfile()
    {
        return view('admin.profile.edit');
    }

    /**
     * Mettre à jour le profil
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->update($validated);

        return redirect()->route('admin.profile.edit')->with('success', 'Profil mis à jour avec succès !');
    }

    public function editPassword()
    {
        return view('admin.profile.password');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->update(['password' => bcrypt($validated['password'])]);

        return redirect()->route('admin.profile.password')->with('success', 'Mot de passe modifié avec succès !');
    }

    /**
     * Afficher la page de personnalisation
     */
    public function customize()
    {
        $settings = \App\Models\DesignerSetting::getForUser(Auth::id());
        return view('admin.customize', compact('settings'));
    }

    /**
     * Enregistrer les paramètres de personnalisation
     */
    public function saveCustomization(Request $request)
    {
        $validated = $request->validate([
            'logo' => 'nullable|image|max:2048',
            'sidebar_bg_color' => 'required|string',
            'sidebar_text_color' => 'required|string',
            'sidebar_active_bg' => 'required|string',
            'sidebar_active_text' => 'required|string',
            'navbar_bg_color' => 'required|string',
            'navbar_text_color' => 'required|string',
            'navbar_accent_color' => 'required|string',
            'primary_color' => 'required|string',
            'secondary_color' => 'required|string',
            'accent_color' => 'required|string',
            'font_family' => 'required|string',
            'font_size' => 'required|integer|min:12|max:24',
        ]);

        $settings = \App\Models\DesignerSetting::getForUser(Auth::id());

        if ($request->hasFile('logo')) {
            $validated['logo_path'] = $request->file('logo')->store('admin-logos', 'public');
            if ($settings->logo_path && Storage::disk('public')->exists($settings->logo_path)) {
                Storage::disk('public')->delete($settings->logo_path);
            }
        }

        $settings->update($validated);

        return redirect()->route('admin.customize')->with('success', 'Personnalisation enregistrée avec succès !');
    }
}