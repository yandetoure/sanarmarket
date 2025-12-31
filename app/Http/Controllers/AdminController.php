<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Announcement;
use App\Models\Boutique;
use App\Models\Restaurant;
use App\Models\Event;
use App\Models\CampusSpotlight;
use App\Models\CampusRestaurantMenu;
use App\Models\UsefulInfo;
use App\Models\SubCategory;
use App\Models\Category;
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
        $pendingValidationAnnouncements = Announcement::where('validation_status', 'pending')->count();
        
        $totalBoutiques = Boutique::count();
        $pendingBoutiques = Boutique::where('validation_status', 'pending')->count();
        $subscribedBoutiques = Boutique::where('is_subscribed', true)->count();
        
        $totalRestaurants = Restaurant::count();
        $pendingRestaurants = Restaurant::where('validation_status', 'pending')->count();
        $subscribedRestaurants = Restaurant::where('is_subscribed', true)->count();
        
        $totalEvents = Event::count();
        $pendingEvents = Event::where('status', Event::STATUS_PENDING)->count();
        
        $totalCampusSpotlights = CampusSpotlight::count();
        $activeCampusSpotlights = CampusSpotlight::where('is_active', true)->count();

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
            'pendingValidationAnnouncements',
            'totalBoutiques',
            'pendingBoutiques',
            'subscribedBoutiques',
            'totalRestaurants',
            'pendingRestaurants',
            'subscribedRestaurants',
            'totalEvents',
            'pendingEvents',
            'totalCampusSpotlights',
            'activeCampusSpotlights',
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
            'role' => 'required|in:user,premium,admin,designer,marketing,ambassador,moderator'
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
            'role' => 'required|in:user,premium,admin,designer,marketing,ambassador,moderator',
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
    public function announcements(Request $request)
    {
        $query = Announcement::with(['user', 'category', 'subcategory', 'media', 'validator']);

        // Filtrage par statut de validation
        if ($request->has('validation_status')) {
            $query->where('validation_status', $request->validation_status);
        }

        // Filtrage par statut
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $announcements = $query->latest()->paginate(20);

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

    /**
     * Approuver une annonce
     */
    public function approveAnnouncement(Announcement $announcement)
    {
        $announcement->update([
            'validation_status' => 'approved',
            'validated_by' => Auth::id(),
            'validated_at' => now(),
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Annonce approuvée avec succès !');
    }

    /**
     * Rejeter une annonce
     */
    public function rejectAnnouncement(Announcement $announcement)
    {
        $announcement->update([
            'validation_status' => 'rejected',
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Annonce rejetée avec succès !');
    }

    /**
     * Liste des boutiques pour l'admin
     */
    public function boutiques()
    {
        $boutiques = Boutique::with(['user'])
            ->withCount('articles')
            ->latest()
            ->paginate(20);

        return view('admin.boutiques', compact('boutiques'));
    }

    /**
     * Approuver une boutique
     */
    public function approveBoutique(Boutique $boutique)
    {
        $boutique->update([
            'validation_status' => 'approved',
            'validated_by' => Auth::id(),
            'validated_at' => now(),
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Boutique approuvée avec succès !');
    }

    /**
     * Rejeter une boutique
     */
    public function rejectBoutique(Boutique $boutique)
    {
        $boutique->update([
            'validation_status' => 'rejected',
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Boutique rejetée avec succès !');
    }

    /**
     * Basculer l'abonnement d'une boutique
     */
    public function toggleBoutiqueSubscription(Boutique $boutique)
    {
        $boutique->update(['is_subscribed' => !$boutique->is_subscribed]);

        $status = $boutique->is_subscribed ? 'abonnée' : 'non abonnée';
        return redirect()->back()->with('success', "Boutique marquée comme {$status} avec succès !");
    }

    /**
     * Liste des restaurants pour l'admin
     */
    public function restaurants()
    {
        $restaurants = Restaurant::with(['user'])
            ->withCount('menuItems')
            ->latest()
            ->paginate(20);

        return view('admin.restaurants', compact('restaurants'));
    }

    /**
     * Basculer l'abonnement d'un restaurant
     */
    public function toggleRestaurantSubscription(Restaurant $restaurant)
    {
        $restaurant->update(['is_subscribed' => !$restaurant->is_subscribed]);

        $status = $restaurant->is_subscribed ? 'abonné' : 'non abonné';
        return redirect()->back()->with('success', "Restaurant marqué comme {$status} avec succès !");
    }

    /**
     * Approuver un restaurant
     */
    public function approveRestaurant(Restaurant $restaurant)
    {
        $restaurant->update([
            'validation_status' => 'approved',
            'validated_by' => Auth::id(),
            'validated_at' => now(),
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Restaurant approuvé avec succès !');
    }

    /**
     * Rejeter un restaurant
     */
    public function rejectRestaurant(Restaurant $restaurant)
    {
        $restaurant->update([
            'validation_status' => 'rejected',
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Restaurant rejeté avec succès !');
    }

    /**
     * Liste des événements pour l'admin
     */
    public function events()
    {
        $events = Event::with(['user'])
            ->latest()
            ->paginate(20);

        return view('admin.events', compact('events'));
    }

    /**
     * Approuver un événement
     */
    public function approveEvent(Event $event)
    {
        $event->update([
            'status' => Event::STATUS_APPROVED,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Événement approuvé avec succès !');
    }

    /**
     * Rejeter un événement
     */
    public function rejectEvent(Event $event)
    {
        $event->update([
            'status' => Event::STATUS_REJECTED,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Événement rejeté avec succès !');
    }

    /**
     * Liste des informations "à la une"
     */
    public function campusSpotlight()
    {
        $spotlights = CampusSpotlight::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.campus-spotlight', compact('spotlights'));
    }

    /**
     * Activer/Désactiver une information "à la une"
     */
    public function toggleCampusSpotlight(CampusSpotlight $campusSpotlight)
    {
        $campusSpotlight->update(['is_active' => !$campusSpotlight->is_active]);

        $status = $campusSpotlight->is_active ? 'activée' : 'désactivée';
        return redirect()->back()->with('success', "Information {$status} avec succès !");
    }

    /**
     * Publier une information "à la une"
     */
    public function publishCampusSpotlight(CampusSpotlight $campusSpotlight)
    {
        $campusSpotlight->update([
            'published_at' => now(),
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Information publiée avec succès !');
    }

    /**
     * Liste des menus du campus
     */
    public function campusRestaurantMenus()
    {
        $menus = CampusRestaurantMenu::with('user')
            ->latest('menu_date')
            ->latest()
            ->paginate(20);

        return view('admin.campus-restaurant-menus', compact('menus'));
    }

    /**
     * Liste des infos utiles
     */
    public function usefulInfo()
    {
        $prayerTimes = UsefulInfo::where('type', UsefulInfo::TYPE_PRAYER_TIMES)->where('is_active', true)->latest()->first();
        $universityContacts = UsefulInfo::where('type', UsefulInfo::TYPE_UNIVERSITY_CONTACT)->where('is_active', true)->get();
        $pharmacyOnDuty = UsefulInfo::where('type', UsefulInfo::TYPE_PHARMACY_ON_DUTY)->where('is_active', true)->latest()->first();
        $campusMap = UsefulInfo::where('type', UsefulInfo::TYPE_CAMPUS_MAP)->where('is_active', true)->latest()->first();

        return view('admin.useful-info', compact('prayerTimes', 'universityContacts', 'pharmacyOnDuty', 'campusMap'));
    }

    /**
     * Mettre à jour les heures de prière
     */
    public function updatePrayerTimes(Request $request)
    {
        $request->validate([
            'data' => 'required|array',
            'data.fajr' => 'required|string',
            'data.dhuhr' => 'required|string',
            'data.asr' => 'required|string',
            'data.maghrib' => 'required|string',
            'data.isha' => 'required|string',
        ]);

        UsefulInfo::updateOrCreate(
            ['type' => UsefulInfo::TYPE_PRAYER_TIMES],
            [
                'title' => 'Heures de prière',
                'data' => $request->data,
                'user_id' => Auth::id(),
                'is_active' => true,
            ]
        );

        return redirect()->route('admin.useful-info')->with('success', 'Heures de prière mises à jour avec succès !');
    }

    /**
     * Ajouter un contact universitaire
     */
    public function storeUniversityContact(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        UsefulInfo::create([
            'type' => UsefulInfo::TYPE_UNIVERSITY_CONTACT,
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
            'is_active' => true,
        ]);

        return redirect()->route('admin.useful-info')->with('success', 'Contact universitaire ajouté avec succès !');
    }

    /**
     * Supprimer un contact universitaire
     */
    public function deleteUniversityContact(UsefulInfo $usefulInfo)
    {
        if ($usefulInfo->type !== UsefulInfo::TYPE_UNIVERSITY_CONTACT) {
            abort(404);
        }

        $usefulInfo->delete();

        return redirect()->route('admin.useful-info')->with('success', 'Contact universitaire supprimé avec succès !');
    }

    /**
     * Mettre à jour la pharmacie de garde
     */
    public function updatePharmacyOnDuty(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $imagePath = $request->file('image')->store('useful-info', 'public');

        // Désactiver l'ancienne image si elle existe
        $oldPharmacy = UsefulInfo::where('type', UsefulInfo::TYPE_PHARMACY_ON_DUTY)
            ->where('is_active', true)
            ->first();
        
        if ($oldPharmacy && $oldPharmacy->image && Storage::disk('public')->exists($oldPharmacy->image)) {
            Storage::disk('public')->delete($oldPharmacy->image);
        }

        if ($oldPharmacy) {
            $oldPharmacy->update(['is_active' => false]);
        }

        UsefulInfo::create([
            'type' => UsefulInfo::TYPE_PHARMACY_ON_DUTY,
            'title' => 'Pharmacie de garde',
            'image' => $imagePath,
            'user_id' => Auth::id(),
            'is_active' => true,
        ]);

        return redirect()->route('admin.useful-info')->with('success', 'Affiche de pharmacie de garde mise à jour avec succès !');
    }

    /**
     * Mettre à jour le plan du campus
     */
    public function updateCampusMap(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120',
            'description' => 'nullable|string|max:500',
        ]);

        $imagePath = $request->file('image')->store('useful-info', 'public');

        // Désactiver l'ancien plan si il existe
        $oldMap = UsefulInfo::where('type', UsefulInfo::TYPE_CAMPUS_MAP)
            ->where('is_active', true)
            ->first();
        
        if ($oldMap && $oldMap->image && Storage::disk('public')->exists($oldMap->image)) {
            Storage::disk('public')->delete($oldMap->image);
        }

        if ($oldMap) {
            $oldMap->update(['is_active' => false]);
        }

        UsefulInfo::create([
            'type' => UsefulInfo::TYPE_CAMPUS_MAP,
            'title' => 'Plan du campus',
            'image' => $imagePath,
            'data' => $request->description ? ['description' => $request->description] : null,
            'user_id' => Auth::id(),
            'is_active' => true,
        ]);

        return redirect()->route('admin.useful-info')->with('success', 'Plan du campus mis à jour avec succès !');
    }

    /**
     * Liste des sous-catégories
     */
    public function subcategories()
    {
        $subcategories = SubCategory::with('category')
            ->latest()
            ->paginate(20);

        $categories = Category::all();

        return view('admin.subcategories', compact('subcategories', 'categories'));
    }

    /**
     * Afficher le formulaire de création de sous-catégorie
     */
    public function createSubcategory()
    {
        $categories = Category::all();
        return view('admin.subcategories.create', compact('categories'));
    }

    /**
     * Créer une sous-catégorie
     */
    public function storeSubcategory(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:sub_categories,slug',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        SubCategory::create($validated);

        return redirect()->route('admin.subcategories')->with('success', 'Sous-catégorie créée avec succès !');
    }

    /**
     * Afficher le formulaire d'édition de sous-catégorie
     */
    public function editSubcategory(SubCategory $subcategory)
    {
        $categories = Category::all();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    /**
     * Mettre à jour une sous-catégorie
     */
    public function updateSubcategory(Request $request, SubCategory $subcategory)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:sub_categories,slug,' . $subcategory->id,
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $subcategory->update($validated);

        return redirect()->route('admin.subcategories')->with('success', 'Sous-catégorie mise à jour avec succès !');
    }

    /**
     * Supprimer une sous-catégorie
     */
    public function destroySubcategory(SubCategory $subcategory)
    {
        $subcategory->delete();

        return redirect()->route('admin.subcategories')->with('success', 'Sous-catégorie supprimée avec succès !');
    }
}
