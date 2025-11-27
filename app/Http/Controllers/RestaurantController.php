<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\RestaurantMenuItem;
use App\Models\RestaurantSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['publicIndex', 'publicShow']);
    }

    // Méthodes publiques (sans authentification)
    public function publicIndex()
    {
        $restaurants = Restaurant::withCount('menuItems')
            ->with(['user', 'menuItems' => function($query) {
                $query->where('is_available', true)->latest()->take(3);
            }])
            ->whereIn('status', ['active', 'draft']) // Afficher les restaurants actifs et en brouillon
            ->latest()
            ->paginate(12);

        return view('restaurants.public.index', [
            'restaurants' => $restaurants,
        ]);
    }

    public function publicShow(Restaurant $restaurant)
    {
        // Permettre l'affichage des restaurants actifs et en brouillon
        if (!in_array($restaurant->status, ['active', 'draft'])) {
            abort(404);
        }

        $restaurant->load(['user', 'menuItems' => function($query) {
            $query->where('is_available', true)->latest();
        }, 'schedules']);

        return view('restaurants.public.show', [
            'restaurant' => $restaurant,
        ]);
    }

    public function index()
    {
        $user = Auth::user();
        
        $restaurants = Restaurant::withCount(['menuItems', 'schedules'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(12);

        // Stats pour la sidebar
        $stats = [
            'total_announcements' => \App\Models\Announcement::where('user_id', $user->id)->count(),
            'active_announcements' => \App\Models\Announcement::where('user_id', $user->id)->where('status', 'active')->count(),
            'total_boutiques' => \App\Models\Boutique::where('user_id', $user->id)->count(),
            'total_restaurants' => Restaurant::where('user_id', $user->id)->count(),
        ];

        return view('restaurants.index', [
            'restaurants' => $restaurants,
            'stats' => $stats,
        ]);
    }

    public function create()
    {
        $user = Auth::user();

        // Stats pour la sidebar
        $stats = [
            'total_announcements' => \App\Models\Announcement::where('user_id', $user->id)->count(),
            'active_announcements' => \App\Models\Announcement::where('user_id', $user->id)->where('status', 'active')->count(),
            'total_boutiques' => \App\Models\Boutique::where('user_id', $user->id)->count(),
            'total_restaurants' => Restaurant::where('user_id', $user->id)->count(),
        ];

        return view('restaurants.create', [
            'stats' => $stats,
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cuisine_type' => 'nullable|string|max:100',
            'price_range' => 'nullable|string|max:50',
        ]);

        // Générer le slug unique
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $counter = 1;
        while (Restaurant::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $validated['user_id'] = $user->id;
        $validated['slug'] = $slug;
        $validated['status'] = 'draft';

        // Gérer l'upload de l'image
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('restaurants', 'public');
        }

        // Stocker les métadonnées supplémentaires
        $metadata = [];
        if (isset($validated['cuisine_type'])) {
            $metadata['cuisine_type'] = $validated['cuisine_type'];
            unset($validated['cuisine_type']);
        }
        if (isset($validated['price_range'])) {
            $metadata['price_range'] = $validated['price_range'];
            unset($validated['price_range']);
        }
        if (!empty($metadata)) {
            $validated['metadata'] = $metadata;
        }

        Restaurant::create($validated);

        return redirect()->route('dashboard.restaurants')->with('success', 'Restaurant créé avec succès !');
    }

    public function show(Restaurant $restaurant)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est propriétaire du restaurant
        if ($restaurant->user_id !== $user->id) {
            abort(403);
        }

        $restaurant->load(['user', 'menuItems', 'schedules']);

        // Stats pour la sidebar
        $stats = [
            'total_announcements' => \App\Models\Announcement::where('user_id', $user->id)->count(),
            'active_announcements' => \App\Models\Announcement::where('user_id', $user->id)->where('status', 'active')->count(),
            'total_boutiques' => \App\Models\Boutique::where('user_id', $user->id)->count(),
            'total_restaurants' => Restaurant::where('user_id', $user->id)->count(),
        ];

        return view('restaurants.show', [
            'restaurant' => $restaurant,
            'stats' => $stats,
        ]);
    }

    public function edit(Restaurant $restaurant)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est propriétaire du restaurant
        if ($restaurant->user_id !== $user->id) {
            abort(403);
        }

        // Stats pour la sidebar
        $stats = [
            'total_announcements' => \App\Models\Announcement::where('user_id', $user->id)->count(),
            'active_announcements' => \App\Models\Announcement::where('user_id', $user->id)->where('status', 'active')->count(),
            'total_boutiques' => \App\Models\Boutique::where('user_id', $user->id)->count(),
            'total_restaurants' => Restaurant::where('user_id', $user->id)->count(),
        ];

        return view('restaurants.edit', [
            'restaurant' => $restaurant,
            'stats' => $stats,
        ]);
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est propriétaire du restaurant
        if ($restaurant->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|in:draft,active,pending',
            'cuisine_type' => 'nullable|string|max:100',
            'price_range' => 'nullable|string|max:50',
        ]);

        // Générer un nouveau slug si le nom a changé
        if ($validated['name'] !== $restaurant->name) {
            $slug = Str::slug($validated['name']);
            $originalSlug = $slug;
            $counter = 1;
            while (Restaurant::where('slug', $slug)->where('id', '!=', $restaurant->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $validated['slug'] = $slug;
        }

        // Gérer l'upload de l'image
        if ($request->hasFile('cover_image')) {
            // Supprimer l'ancienne image si elle existe
            if ($restaurant->cover_image) {
                Storage::disk('public')->delete($restaurant->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('restaurants', 'public');
        }

        // Stocker les métadonnées supplémentaires
        $metadata = [];
        if (isset($validated['cuisine_type'])) {
            $metadata['cuisine_type'] = $validated['cuisine_type'];
            unset($validated['cuisine_type']);
        }
        if (isset($validated['price_range'])) {
            $metadata['price_range'] = $validated['price_range'];
            unset($validated['price_range']);
        }
        if (!empty($metadata)) {
            $validated['metadata'] = $metadata;
        }

        $restaurant->update($validated);

        return redirect()->route('restaurants.show', $restaurant)->with('success', 'Restaurant mis à jour avec succès !');
    }

    public function manage(Restaurant $restaurant)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est propriétaire du restaurant
        if ($restaurant->user_id !== $user->id) {
            abort(403);
        }

        // Recharger le restaurant avec les counts et relations
        $restaurant = Restaurant::withCount(['menuItems', 'schedules'])
            ->with(['menuItems', 'schedules'])
            ->findOrFail($restaurant->id);

        // Stats pour la sidebar
        $stats = [
            'total_announcements' => \App\Models\Announcement::where('user_id', $user->id)->count(),
            'active_announcements' => \App\Models\Announcement::where('user_id', $user->id)->where('status', 'active')->count(),
            'total_boutiques' => \App\Models\Boutique::where('user_id', $user->id)->count(),
            'total_restaurants' => Restaurant::where('user_id', $user->id)->count(),
        ];

        return view('restaurants.manage', [
            'restaurant' => $restaurant,
            'stats' => $stats,
        ]);
    }

    public function createMenuItem(Restaurant $restaurant)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est propriétaire du restaurant
        if ($restaurant->user_id !== $user->id) {
            abort(403);
        }

        // Stats pour la sidebar
        $stats = [
            'total_announcements' => \App\Models\Announcement::where('user_id', $user->id)->count(),
            'active_announcements' => \App\Models\Announcement::where('user_id', $user->id)->where('status', 'active')->count(),
            'total_boutiques' => \App\Models\Boutique::where('user_id', $user->id)->count(),
            'total_restaurants' => Restaurant::where('user_id', $user->id)->count(),
        ];

        return view('restaurants.menu-items.create', [
            'restaurant' => $restaurant,
            'stats' => $stats,
        ]);
    }

    public function storeMenuItem(Request $request, Restaurant $restaurant)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est propriétaire du restaurant
        if ($restaurant->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'availability_type' => 'nullable|in:daily,weekly,time_range',
            'day_of_week' => 'nullable|integer|between:0,6',
            'starts_at' => 'nullable|date_format:H:i',
            'ends_at' => 'nullable|date_format:H:i',
            'is_available' => 'nullable|boolean',
        ]);

        // Générer le slug unique pour ce restaurant
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;
        while (RestaurantMenuItem::where('restaurant_id', $restaurant->id)->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $validated['restaurant_id'] = $restaurant->id;
        $validated['slug'] = $slug;
        $validated['is_available'] = $validated['is_available'] ?? true;
        $validated['availability_type'] = $validated['availability_type'] ?? 'daily';

        RestaurantMenuItem::create($validated);

        return redirect()->route('restaurants.manage', $restaurant)->with('success', 'Plat ajouté au menu avec succès !');
    }

    public function createSchedule(Restaurant $restaurant)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est propriétaire du restaurant
        if ($restaurant->user_id !== $user->id) {
            abort(403);
        }

        // Stats pour la sidebar
        $stats = [
            'total_announcements' => \App\Models\Announcement::where('user_id', $user->id)->count(),
            'active_announcements' => \App\Models\Announcement::where('user_id', $user->id)->where('status', 'active')->count(),
            'total_boutiques' => \App\Models\Boutique::where('user_id', $user->id)->count(),
            'total_restaurants' => Restaurant::where('user_id', $user->id)->count(),
        ];

        return view('restaurants.schedules.create', [
            'restaurant' => $restaurant,
            'stats' => $stats,
        ]);
    }

    public function storeSchedule(Request $request, Restaurant $restaurant)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est propriétaire du restaurant
        if ($restaurant->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'day_of_week' => 'required|integer|between:0,6',
            'opens_at' => 'nullable|date_format:H:i',
            'closes_at' => 'nullable|date_format:H:i',
            'is_closed' => 'nullable|boolean',
        ]);

        // Si le restaurant est fermé, on n'a pas besoin des heures
        $isClosed = isset($validated['is_closed']) && $validated['is_closed'];
        
        if ($isClosed) {
            $validated['opens_at'] = null;
            $validated['closes_at'] = null;
            $validated['is_closed'] = true;
        } else {
            // Vérifier que les heures sont fournies si le restaurant est ouvert
            if (empty($validated['opens_at']) || empty($validated['closes_at'])) {
                return redirect()->back()->withErrors(['opens_at' => 'Les heures d\'ouverture et de fermeture sont requises lorsque le restaurant est ouvert.'])->withInput();
            }
            $validated['is_closed'] = false;
        }

        $validated['restaurant_id'] = $restaurant->id;
        $validated['is_closed'] = $validated['is_closed'] ?? false;

        RestaurantSchedule::create($validated);

        return redirect()->route('restaurants.manage', $restaurant)->with('success', 'Horaire ajouté avec succès !');
    }
}

