<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
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
     * Liste des catégories
     */
    public function index()
    {
        $categories = Category::withCount('announcements')->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Créer une nouvelle catégorie
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories',
            'icon' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée avec succès !');
    }

    /**
     * Afficher une catégorie
     */
    public function show(Category $category)
    {
        $category->load('announcements.user');
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Formulaire d'édition
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Mettre à jour une catégorie
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'icon' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour avec succès !');
    }

    /**
     * Supprimer une catégorie
     */
    public function destroy(Category $category)
    {
        // Vérifier s'il y a des annonces dans cette catégorie
        if ($category->announcements()->count() > 0) {
            return redirect()->back()->with('error', 'Impossible de supprimer une catégorie qui contient des annonces.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée avec succès !');
    }

    /**
     * API: Liste des catégories
     */
    public function apiIndex()
    {
        $categories = Category::withCount('announcements')->get();
        return response()->json($categories);
    }

    /**
     * API: Afficher une catégorie
     */
    public function apiShow($id)
    {
        $category = Category::with('announcements.user')->findOrFail($id);
        return response()->json($category);
    }
}