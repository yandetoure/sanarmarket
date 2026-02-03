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
use Illuminate\Support\Facades\DB;

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

        $stats = [
            'total' => User::count(),
            'active' => User::where('is_active', true)->count(),
            'premium' => User::where('is_premium', true)->count(),
            'admins' => User::where('role', User::ROLE_ADMIN)->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Afficher les détails d'un utilisateur
     */
    public function showUser(User $user)
    {
        $user->load(['activeSubscription.plan', 'announcements', 'boutiques', 'restaurants']);
        $subscriptionPlans = \App\Models\SubscriptionPlan::where('is_active', true)->get();

        return view('admin.users.show', compact('user', 'subscriptionPlans'));
    }

    /**
     * Assigner manuellement un abonnement
     */
    public function storeUserSubscription(Request $request, User $user)
    {
        $request->validate([
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'duration_days' => 'nullable|integer|min:1',
        ]);

        $plan = \App\Models\SubscriptionPlan::findOrFail($request->subscription_plan_id);
        $duration = $request->duration_days ?? $plan->duration_days;

        // Cancel existing active subscription if any
        if ($user->activeSubscription) {
            $user->activeSubscription->update(['status' => 'cancelled']);
        }

        \App\Models\UserSubscription::create([
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'starts_at' => now(),
            'ends_at' => now()->addDays($duration),
            'status' => 'active',
            'payment_reference' => 'MANUAL_ADMIN_' . Auth::id(),
        ]);

        return redirect()->back()->with('success', "Abonnement {$plan->name} assigné avec succès !");
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
     * Formulaire modification utilisateur
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Mettre à jour utilisateur
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:user,premium,admin,designer,marketing,ambassador,moderator',
            'is_active' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->has('is_active');

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'Utilisateur mis à jour avec succès');
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

        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * Formulaire de création d'annonce
     */
    public function createAnnouncement()
    {
        $categories = Category::all();
        $subcategories = SubCategory::all();
        return view('admin.announcements.create', compact('categories', 'subcategories'));
    }

    /**
     * Sauvegarder l'annonce
     */
    public function storeAnnouncement(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'location' => 'required|string',
            'phone' => 'nullable|string',
        ]);

        $announcement = new Announcement($request->all());
        $announcement->user_id = Auth::id(); // Admin creates it
        $announcement->status = 'pending';
        $announcement->validation_status = 'pending'; // Do not auto-validate
        $announcement->save();

        return redirect()->route('admin.announcements')->with('success', 'Annonce créée avec succès');
    }

    /**
     * Formulaire d'édition d'annonce
     */
    public function editAnnouncement(Announcement $announcement)
    {
        $categories = Category::all();
        $subcategories = SubCategory::all();
        return view('admin.announcements.edit', compact('announcement', 'categories', 'subcategories'));
    }

    /**
     * Mettre à jour l'annonce
     */
    public function updateAnnouncement(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'location' => 'required|string',
            'phone' => 'nullable|string',
        ]);

        $announcement->update($request->all());

        return redirect()->route('admin.announcements')->with('success', 'Annonce mise à jour');
    }

    /**
     * Afficher les détails d'une annonce
     */
    public function showAnnouncement(Announcement $announcement)
    {
        $announcement->load(['user', 'category', 'subcategory', 'media', 'validator']);
        return view('admin.announcements.show', compact('announcement'));
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

        return view('admin.boutiques.index', compact('boutiques'));
    }

    /**
     * Formulaire création boutique
     */
    public function createBoutique()
    {
        $users = User::all(); // Should optimize this if many users
        return view('admin.boutiques.create', compact('users'));
    }

    /**
     * Sauvegarder nouvelle boutique
     */
    public function storeBoutique(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        $boutique = new Boutique($request->all());
        $boutique->validation_status = 'approved';
        $boutique->save();

        return redirect()->route('admin.boutiques.show', $boutique)->with('success', 'Boutique créée avec succès');
    }

    /**
     * Afficher les détails d'une boutique
     */
    public function showBoutique(Boutique $boutique)
    {
        $boutique->load(['user', 'articles', 'validator']);
        return view('admin.boutiques.show', compact('boutique'));
    }

    /**
     * Formulaire modification boutique
     */
    public function editBoutique(Boutique $boutique)
    {
        $users = User::all();
        return view('admin.boutiques.edit', compact('boutique', 'users'));
    }

    /**
     * Mettre à jour boutique
     */
    public function updateBoutique(Request $request, Boutique $boutique)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        $boutique->update($request->all());

        return redirect()->route('admin.boutiques.show', $boutique)->with('success', 'Boutique mise à jour');
    }

    /**
     * Supprimer boutique
     */
    public function destroyBoutique(Boutique $boutique)
    {
        $boutique->delete();
        return redirect()->route('admin.boutiques')->with('success', 'Boutique supprimée');
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

        return view('admin.restaurants.index', compact('restaurants'));
    }

    /**
     * Formulaire création restaurant
     */
    public function createRestaurant()
    {
        $users = User::all();
        return view('admin.restaurants.create', compact('users'));
    }

    /**
     * Sauvegarder nouveau restaurant
     */
    public function storeRestaurant(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        $restaurant = new Restaurant($request->all());
        $restaurant->validation_status = 'approved';
        $restaurant->save();

        return redirect()->route('admin.restaurants.show', $restaurant)->with('success', 'Restaurant créé avec succès');
    }

    /**
     * Afficher les détails d'un restaurant
     */
    public function showRestaurant(Restaurant $restaurant)
    {
        $restaurant->load(['user', 'menuItems', 'validator']);
        return view('admin.restaurants.show', compact('restaurant'));
    }

    /**
     * Formulaire modification restaurant
     */
    public function editRestaurant(Restaurant $restaurant)
    {
        $users = User::all();
        return view('admin.restaurants.edit', compact('restaurant', 'users'));
    }

    /**
     * Mettre à jour restaurant
     */
    public function updateRestaurant(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        $restaurant->update($request->all());

        return redirect()->route('admin.restaurants.show', $restaurant)->with('success', 'Restaurant mis à jour');
    }

    /**
     * Supprimer restaurant
     */
    public function destroyRestaurant(Restaurant $restaurant)
    {
        $restaurant->delete();
        return redirect()->route('admin.restaurants')->with('success', 'Restaurant supprimé');
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
     * Formulaire création événement
     */
    public function createEvent()
    {
        $users = User::all();
        return view('admin.events.create', compact('users'));
    }

    /**
     * Sauvegarder nouvel événement
     */
    public function storeEvent(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string',
        ]);

        $event = new Event($request->all());
        $event->status = Event::STATUS_PENDING;
        // $event->approved_by = Auth::id(); // Removed auto-approval
        // $event->approved_at = now();      // Removed auto-approval
        $event->save();

        return redirect()->route('admin.events')->with('success', 'Événement créé avec succès');
    }

    /**
     * Formulaire modification événement
     */
    public function editEvent(Event $event)
    {
        $users = User::all();
        return view('admin.events.edit', compact('event', 'users'));
    }

    /**
     * Mettre à jour événement
     */
    public function updateEvent(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string',
        ]);

        $event->update($request->all());

        return redirect()->route('admin.events')->with('success', 'Événement mis à jour');
    }

    /**
     * Supprimer événement
     */
    public function destroyEvent(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events')->with('success', 'Événement supprimé');
    }

    /**
     * Liste des événements pour l'admin
     */
    public function events()
    {
        $events = Event::with(['user'])
            ->latest()
            ->paginate(20);

        return view('admin.events.index', compact('events'));
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
     * Formulaire création À la Une
     */
    public function createCampusSpotlight()
    {
        return view('admin.campus-spotlight.create');
    }

    /**
     * Sauvegarder À la Une
     */
    public function storeCampusSpotlight(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:news,event,info',
        ]);

        $spotlight = new CampusSpotlight($request->all());
        $spotlight->user_id = Auth::id();
        $spotlight->is_active = true;
        $spotlight->published_at = now();
        $spotlight->save();

        return redirect()->route('admin.campus-spotlight')->with('success', 'Article créé avec succès');
    }

    /**
     * Formulaire modification À la Une
     */
    public function editCampusSpotlight(CampusSpotlight $campusSpotlight)
    {
        return view('admin.campus-spotlight.edit', compact('campusSpotlight'));
    }

    /**
     * Mettre à jour À la Une
     */
    public function updateCampusSpotlight(Request $request, CampusSpotlight $campusSpotlight)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:news,event,info',
        ]);

        $campusSpotlight->update($request->all());

        return redirect()->route('admin.campus-spotlight')->with('success', 'Article mis à jour');
    }

    /**
     * Supprimer À la Une
     */
    public function destroyCampusSpotlight(CampusSpotlight $campusSpotlight)
    {
        $campusSpotlight->delete();
        return redirect()->route('admin.campus-spotlight')->with('success', 'Article supprimé');
    }

    /**
     * Liste des informations "à la une"
     */
    public function campusSpotlight()
    {
        $spotlights = CampusSpotlight::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.campus-spotlight.index', compact('spotlights'));
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

        // Prepare data for view
        $contacts = $universityContacts;
        $pharmacy = $pharmacyOnDuty ? [
            'name' => $pharmacyOnDuty->data['name'] ?? '',
            'address' => $pharmacyOnDuty->data['address'] ?? '',
            'phone' => $pharmacyOnDuty->data['phone'] ?? '',
        ] : [];

        return view('admin.useful-info.index', compact('prayerTimes', 'contacts', 'pharmacy'));
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

        return view('admin.subcategories.index', compact('subcategories', 'categories'));
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
