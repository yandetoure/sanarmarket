<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\BoutiqueCategory;
use App\Models\BoutiqueArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BoutiqueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['publicIndex', 'publicShow']);
    }

    // Méthodes publiques (sans authentification)
    public function publicIndex(Request $request)
    {
        $query = Boutique::withCount('articles')
            ->with(['user', 'articles' => function($query) {
                $query->where('status', 'active')->latest()->take(3);
            }])
            ->where('validation_status', 'approved')
            ->whereIn('status', ['active', 'draft']); // Afficher les boutiques actives et en brouillon

        // Filtrer par type (boutique ou restaurant)
        if ($request->has('type')) {
            // Pour l'instant, toutes les boutiques sont des boutiques
        }

        // Trier : boutiques abonnées en premier
        $boutiques = $query->orderBy('is_subscribed', 'desc')
            ->latest()
            ->paginate(12);

        return view('boutiques.public.index', [
            'boutiques' => $boutiques,
        ]);
    }

    public function publicShow(Boutique $boutique)
    {
        // Permettre l'affichage uniquement des boutiques approuvées
        if (!in_array($boutique->status, ['active', 'draft']) || $boutique->validation_status !== 'approved') {
            abort(404);
        }

        $boutique->load(['user', 'categories', 'articles' => function($query) {
            $query->where('status', 'active')->with('category')->latest();
        }]);

        return view('boutiques.public.show', [
            'boutique' => $boutique,
        ]);
    }

    public function index()
    {
        $user = Auth::user();
        
        $boutiques = Boutique::withCount(['articles', 'categories'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(12);

        // Stats pour la sidebar
        $stats = [
            'total_announcements' => \App\Models\Announcement::where('user_id', $user->id)->count(),
            'active_announcements' => \App\Models\Announcement::where('user_id', $user->id)->where('status', 'active')->count(),
            'total_boutiques' => Boutique::where('user_id', $user->id)->count(),
            'total_restaurants' => \App\Models\Restaurant::where('user_id', $user->id)->count(),
        ];

        return view('boutiques.index', [
            'boutiques' => $boutiques,
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
            'total_boutiques' => Boutique::where('user_id', $user->id)->count(),
            'total_restaurants' => \App\Models\Restaurant::where('user_id', $user->id)->count(),
        ];

        return view('boutiques.create', [
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
            'social_links' => 'nullable|array',
            'social_links.facebook' => 'nullable|url',
            'social_links.instagram' => 'nullable|url',
            'social_links.twitter' => 'nullable|url',
            'social_links.website' => 'nullable|url',
        ]);

        // Générer le slug unique
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $counter = 1;
        while (Boutique::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $validated['user_id'] = $user->id;
        $validated['slug'] = $slug;
        $validated['status'] = 'draft';
        $validated['validation_status'] = 'pending'; // Les boutiques doivent être validées par un ambassadeur

        // Gérer l'upload de l'image
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('boutiques', 'public');
        }

        // Nettoyer les liens sociaux vides
        if (isset($validated['social_links'])) {
            $validated['social_links'] = array_filter($validated['social_links']);
        }

        Boutique::create($validated);

        return redirect()->route('dashboard.boutiques')->with('success', 'Boutique créée avec succès ! Elle sera visible après validation par un ambassadeur.');
    }

    public function show(Boutique $boutique)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est propriétaire de la boutique
        if ($boutique->user_id !== $user->id) {
            abort(403);
        }

        $boutique->load(['user', 'articles', 'categories']);

        // Stats pour la sidebar
        $stats = [
            'total_announcements' => \App\Models\Announcement::where('user_id', $user->id)->count(),
            'active_announcements' => \App\Models\Announcement::where('user_id', $user->id)->where('status', 'active')->count(),
            'total_boutiques' => Boutique::where('user_id', $user->id)->count(),
            'total_restaurants' => \App\Models\Restaurant::where('user_id', $user->id)->count(),
        ];

        return view('boutiques.show', [
            'boutique' => $boutique,
            'stats' => $stats,
        ]);
    }

    public function edit(Boutique $boutique)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est propriétaire de la boutique
        if ($boutique->user_id !== $user->id) {
            abort(403);
        }

        // Stats pour la sidebar
        $stats = [
            'total_announcements' => \App\Models\Announcement::where('user_id', $user->id)->count(),
            'active_announcements' => \App\Models\Announcement::where('user_id', $user->id)->where('status', 'active')->count(),
            'total_boutiques' => Boutique::where('user_id', $user->id)->count(),
            'total_restaurants' => \App\Models\Restaurant::where('user_id', $user->id)->count(),
        ];

        return view('boutiques.edit', [
            'boutique' => $boutique,
            'stats' => $stats,
        ]);
    }

    public function update(Request $request, Boutique $boutique)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est propriétaire de la boutique
        if ($boutique->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|in:draft,active,pending',
            'social_links' => 'nullable|array',
            'social_links.facebook' => 'nullable|url',
            'social_links.instagram' => 'nullable|url',
            'social_links.twitter' => 'nullable|url',
            'social_links.website' => 'nullable|url',
        ]);

        // Générer un nouveau slug si le nom a changé
        if ($validated['name'] !== $boutique->name) {
            $slug = Str::slug($validated['name']);
            $originalSlug = $slug;
            $counter = 1;
            while (Boutique::where('slug', $slug)->where('id', '!=', $boutique->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $validated['slug'] = $slug;
        }

        // Gérer l'upload de l'image
        if ($request->hasFile('cover_image')) {
            // Supprimer l'ancienne image si elle existe
            if ($boutique->cover_image) {
                Storage::disk('public')->delete($boutique->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('boutiques', 'public');
        }

        // Nettoyer les liens sociaux vides
        if (isset($validated['social_links'])) {
            $validated['social_links'] = array_filter($validated['social_links']);
        }

        $boutique->update($validated);

        return redirect()->route('boutiques.show', $boutique)->with('success', 'Boutique mise à jour avec succès !');
    }

    public function manage(Boutique $boutique)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est propriétaire de la boutique
        if ($boutique->user_id !== $user->id) {
            abort(403);
        }

        // Recharger la boutique avec les counts et relations
        $boutique = Boutique::withCount(['articles', 'categories'])
            ->with(['categories' => function($query) {
                $query->withCount('articles');
            }, 'articles.category'])
            ->findOrFail($boutique->id);

        // Stats pour la sidebar
        $stats = [
            'total_announcements' => \App\Models\Announcement::where('user_id', $user->id)->count(),
            'active_announcements' => \App\Models\Announcement::where('user_id', $user->id)->where('status', 'active')->count(),
            'total_boutiques' => Boutique::where('user_id', $user->id)->count(),
            'total_restaurants' => \App\Models\Restaurant::where('user_id', $user->id)->count(),
        ];

        return view('boutiques.manage', [
            'boutique' => $boutique,
            'stats' => $stats,
        ]);
    }

    public function createCategory(Boutique $boutique)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est propriétaire de la boutique
        if ($boutique->user_id !== $user->id) {
            abort(403);
        }

        // Stats pour la sidebar
        $stats = [
            'total_announcements' => \App\Models\Announcement::where('user_id', $user->id)->count(),
            'active_announcements' => \App\Models\Announcement::where('user_id', $user->id)->where('status', 'active')->count(),
            'total_boutiques' => Boutique::where('user_id', $user->id)->count(),
            'total_restaurants' => \App\Models\Restaurant::where('user_id', $user->id)->count(),
        ];

        return view('boutiques.categories.create', [
            'boutique' => $boutique,
            'stats' => $stats,
        ]);
    }

    public function storeCategory(Request $request, Boutique $boutique)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est propriétaire de la boutique
        if ($boutique->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Générer le slug unique pour cette boutique
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $counter = 1;
        while (BoutiqueCategory::where('boutique_id', $boutique->id)->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $validated['boutique_id'] = $boutique->id;
        $validated['slug'] = $slug;

        BoutiqueCategory::create($validated);

        return redirect()->route('boutiques.manage', $boutique)->with('success', 'Catégorie créée avec succès !');
    }

    public function createArticle(Boutique $boutique)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est propriétaire de la boutique
        if ($boutique->user_id !== $user->id) {
            abort(403);
        }

        $categories = $boutique->categories;

        // Stats pour la sidebar
        $stats = [
            'total_announcements' => \App\Models\Announcement::where('user_id', $user->id)->count(),
            'active_announcements' => \App\Models\Announcement::where('user_id', $user->id)->where('status', 'active')->count(),
            'total_boutiques' => Boutique::where('user_id', $user->id)->count(),
            'total_restaurants' => \App\Models\Restaurant::where('user_id', $user->id)->count(),
        ];

        return view('boutiques.articles.create', [
            'boutique' => $boutique,
            'categories' => $categories,
            'stats' => $stats,
        ]);
    }

    public function storeArticle(Request $request, Boutique $boutique)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est propriétaire de la boutique
        if ($boutique->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'boutique_category_id' => 'nullable|exists:boutique_categories,id',
            'status' => 'nullable|in:draft,active,pending',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Vérifier que la catégorie appartient à la boutique
        if (isset($validated['boutique_category_id'])) {
            $category = BoutiqueCategory::where('id', $validated['boutique_category_id'])
                ->where('boutique_id', $boutique->id)
                ->first();
            
            if (!$category) {
                return redirect()->back()->withErrors(['boutique_category_id' => 'La catégorie sélectionnée n\'appartient pas à cette boutique.']);
            }
        }

        // Générer le slug unique pour cette boutique
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $counter = 1;
        while (BoutiqueArticle::where('boutique_id', $boutique->id)->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $validated['boutique_id'] = $boutique->id;
        $validated['slug'] = $slug;
        $validated['status'] = $validated['status'] ?? 'draft';

        // Gérer l'upload de l'image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('boutiques/articles', 'public');
        }

        BoutiqueArticle::create($validated);

        return redirect()->route('boutiques.manage', $boutique)->with('success', 'Article créé avec succès !');
    }
}

