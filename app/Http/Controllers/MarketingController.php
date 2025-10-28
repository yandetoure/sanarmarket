<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()?->isMarketing()) {
                abort(403, 'Accès non autorisé');
            }
            return $next($request);
        });
    }

    /**
     * Dashboard marketing
     */
    public function dashboard()
    {
        $totalAdvertisements = Advertisement::count();
        $activeAdvertisements = Advertisement::where('is_active', true)->count();
        $totalAnnouncements = Announcement::count();
        $activeAnnouncements = Announcement::active()->count();
        
        $performanceStats = [
            'views' => rand(1000, 10000),
            'clicks' => rand(50, 500),
            'conversion' => rand(1, 10) . '%',
        ];

        $recentAds = Advertisement::with(['category'])
            ->latest()
            ->take(10)
            ->get();

        $recentAnnouncements = Announcement::with(['user', 'category'])
            ->latest()
            ->take(10)
            ->get();

        return view('marketing.dashboard', compact(
            'totalAdvertisements',
            'activeAdvertisements',
            'totalAnnouncements',
            'activeAnnouncements',
            'performanceStats',
            'recentAds',
            'recentAnnouncements'
        ));
    }

    /**
     * Gestion des publicités
     */
    public function advertisements()
    {
        $advertisements = Advertisement::with(['category', 'designer'])
            ->latest()
            ->paginate(20);
            
        return view('marketing.advertisements', compact('advertisements'));
    }

    /**
     * Activer/Désactiver une publicité
     */
    public function toggleAdvertisement(Advertisement $advertisement)
    {
        $advertisement->update(['is_active' => !$advertisement->is_active]);
        
        $status = $advertisement->is_active ? 'activée' : 'désactivée';
        return redirect()->back()->with('success', "Publicité {$status} avec succès !");
    }

    /**
     * Statistiques de performance
     */
    public function statistics()
    {
        $stats = [
            'total_impressions' => rand(50000, 200000),
            'total_clicks' => rand(2000, 10000),
            'ctr' => rand(3, 8) . '%',
            'conversion_rate' => rand(5, 15) . '%',
            'revenue' => number_format(rand(10000, 50000), 2, ',', ' ') . ' FCFA',
        ];

        $topAds = Advertisement::where('is_active', true)
            ->withCount('views')
            ->orderBy('views_count', 'desc')
            ->take(10)
            ->get();

        return view('marketing.statistics', compact('stats', 'topAds'));
    }

    /**
     * Promouvoir une annonce
     */
    public function promoteAnnouncement(Announcement $announcement)
    {
        $announcement->update(['featured' => !$announcement->featured]);
        
        $status = $announcement->featured ? 'promue' : 'dépromue';
        return redirect()->back()->with('success', "Annonce {$status} avec succès !");
    }

    /**
     * Afficher le formulaire de modification du profil
     */
    public function editProfile()
    {
        return view('marketing.profile.edit');
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

        return redirect()->route('marketing.profile.edit')->with('success', 'Profil mis à jour avec succès !');
    }

    public function editPassword()
    {
        return view('marketing.profile.edit');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!\Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->update(['password' => bcrypt($validated['password'])]);

        return redirect()->route('marketing.profile.edit')->with('success', 'Mot de passe modifié avec succès !');
    }
}

