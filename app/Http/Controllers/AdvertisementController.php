<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
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
     * Liste des publicités
     */
    public function index()
    {
        $advertisements = Advertisement::latest()->paginate(20);
        return view('admin.advertisements.index', compact('advertisements'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        return view('admin.advertisements.create');
    }

    /**
     * Créer une nouvelle publicité
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'type' => 'required|in:popup,banner',
            'position' => 'required|in:hero,popup',
            'display_duration' => 'required|integer|min:1|max:365',
            'popup_duration' => 'nullable|integer|min:1|max:60',
            'is_active' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        // Gestion de l'upload d'image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('advertisements', 'public');
        }

        // Validation spécifique selon le type
        if ($validated['type'] === 'popup' && !$validated['popup_duration']) {
            return back()->withErrors(['popup_duration' => 'La durée d\'affichage est requise pour les popups.']);
        }

        Advertisement::create($validated);

        return redirect()->route('admin.advertisements.index')->with('success', 'Publicité créée avec succès !');
    }

    /**
     * Afficher une publicité
     */
    public function show(Advertisement $advertisement)
    {
        return view('admin.advertisements.show', compact('advertisement'));
    }

    /**
     * Formulaire d'édition
     */
    public function edit(Advertisement $advertisement)
    {
        return view('admin.advertisements.edit', compact('advertisement'));
    }

    /**
     * Mettre à jour une publicité
     */
    public function update(Request $request, Advertisement $advertisement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'type' => 'required|in:popup,banner',
            'position' => 'required|in:hero,popup',
            'display_duration' => 'required|integer|min:1|max:365',
            'popup_duration' => 'nullable|integer|min:1|max:60',
            'is_active' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        // Gestion de l'upload d'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($advertisement->image && Storage::disk('public')->exists($advertisement->image)) {
                Storage::disk('public')->delete($advertisement->image);
            }
            $validated['image'] = $request->file('image')->store('advertisements', 'public');
        }

        // Validation spécifique selon le type
        if ($validated['type'] === 'popup' && !$validated['popup_duration']) {
            return back()->withErrors(['popup_duration' => 'La durée d\'affichage est requise pour les popups.']);
        }

        $advertisement->update($validated);

        return redirect()->route('admin.advertisements.index')->with('success', 'Publicité mise à jour avec succès !');
    }

    /**
     * Supprimer une publicité
     */
    public function destroy(Advertisement $advertisement)
    {
        // Supprimer l'image si elle existe
        if ($advertisement->image && Storage::disk('public')->exists($advertisement->image)) {
            Storage::disk('public')->delete($advertisement->image);
        }

        $advertisement->delete();

        return redirect()->route('admin.advertisements.index')->with('success', 'Publicité supprimée avec succès !');
    }

    /**
     * Activer/Désactiver une publicité
     */
    public function toggle(Advertisement $advertisement)
    {
        $advertisement->update(['is_active' => !$advertisement->is_active]);
        
        $status = $advertisement->is_active ? 'activée' : 'désactivée';
        return redirect()->back()->with('success', "Publicité {$status} avec succès !");
    }

    /**
     * API pour récupérer les publicités actives (pour le frontend)
     */
    public function getActiveAdvertisements()
    {
        $heroBanners = Advertisement::currentlyActive()->heroBanners()->get();
        $popups = Advertisement::currentlyActive()->popups()->get();

        return response()->json([
            'hero_banners' => $heroBanners,
            'popups' => $popups,
        ]);
    }
}