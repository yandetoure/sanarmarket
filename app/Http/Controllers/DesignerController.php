<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()?->isDesigner()) {
                abort(403, 'Accès non autorisé');
            }
            return $next($request);
        });
    }

    /**
     * Dashboard designer
     */
    public function dashboard()
    {
        $myDesigns = Advertisement::where('designer_id', Auth::id())->count();
        $activeAdvertisements = Advertisement::where('designer_id', Auth::id())
            ->where('is_active', true)
            ->count();
        $totalAdvertisements = $myDesigns; // For designer, show only their ads
        
        $recentAds = Advertisement::where('designer_id', Auth::id())
            ->with(['category'])
            ->latest()
            ->take(10)
            ->get();

        return view('designer.dashboard', compact(
            'totalAdvertisements',
            'activeAdvertisements',
            'myDesigns',
            'recentAds'
        ));
    }

    /**
     * Mes créations
     */
    public function myDesigns()
    {
        $advertisements = Advertisement::where('designer_id', Auth::id())
            ->with(['category'])
            ->latest()
            ->paginate(20);
            
        return view('designer.my-designs', compact('advertisements'));
    }

    /**
     * Créer une nouvelle publicité
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('designer.create', compact('categories'));
    }

    /**
     * Enregistrer une nouvelle publicité
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'boolean',
        ]);

        $validated['designer_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('advertisements', 'public');
        }

        Advertisement::create($validated);

        return redirect()->route('designer.my-designs')->with('success', 'Publicité créée avec succès !');
    }

    /**
     * Modifier une publicité
     */
    public function edit(Advertisement $advertisement)
    {
        if ($advertisement->designer_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez pas modifier cette publicité');
        }

        $categories = \App\Models\Category::all();
        return view('designer.edit', compact('advertisement', 'categories'));
    }

    /**
     * Mettre à jour une publicité
     */
    public function update(Request $request, Advertisement $advertisement)
    {
        if ($advertisement->designer_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez pas modifier cette publicité');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('advertisements', 'public');
        }

        $advertisement->update($validated);

        return redirect()->route('designer.my-designs')->with('success', 'Publicité modifiée avec succès !');
    }

    /**
     * Afficher la page de personnalisation
     */
    public function customize()
    {
        $settings = \App\Models\DesignerSetting::getForUser(Auth::id());
        return view('designer.customize', compact('settings'));
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
            $validated['logo_path'] = $request->file('logo')->store('designer-logos', 'public');
            if ($settings->logo_path && \Storage::disk('public')->exists($settings->logo_path)) {
                \Storage::disk('public')->delete($settings->logo_path);
            }
        }

        $settings->update($validated);

        return redirect()->route('designer.customize')->with('success', 'Personnalisation enregistrée avec succès !');
    }
}

