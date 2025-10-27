<?php declare(strict_types=1); 

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::with(['user', 'category'])->visible()->latest();

        // Filtrage par catégorie
        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Recherche par titre ou description
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $announcements = $query->paginate(12);

        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('announcements.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['user_id'] = Auth::id();

        // Gestion de l'upload d'image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('announcements', 'public');
        }

        Announcement::create($validated);

        return redirect()->route('announcements.index')->with('success', 'Annonce créée avec succès !');
    }

    public function show(Announcement $announcement)
    {
        // Vérifier si l'annonce est visible ou si l'utilisateur est admin
        if (!$announcement->isActive() && !Auth::user()?->isAdmin()) {
            abort(404);
        }
        
        $announcement->load(['user', 'category']);
        return view('announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        $this->authorize('update', $announcement);
        $categories = \App\Models\Category::all();
        return view('announcements.edit', compact('announcement', 'categories'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $this->authorize('update', $announcement);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($announcement->image && Storage::disk('public')->exists($announcement->image)) {
                Storage::disk('public')->delete($announcement->image);
            }
            $validated['image'] = $request->file('image')->store('announcements', 'public');
        }

        $announcement->update($validated);

        return redirect()->route('announcements.show', $announcement)->with('success', 'Annonce mise à jour avec succès !');
    }

    public function destroy(Announcement $announcement)
    {
        $this->authorize('delete', $announcement);

        // Supprimer l'image si elle existe
        if ($announcement->image && Storage::disk('public')->exists($announcement->image)) {
            Storage::disk('public')->delete($announcement->image);
        }

        $announcement->delete();

        return redirect()->route('announcements.index')->with('success', 'Annonce supprimée avec succès !');
    }

    /**
     * Admin: Masquer une annonce
     */
    public function hide(Announcement $announcement)
    {
        $this->authorize('manage', $announcement);
        
        $announcement->update(['status' => 'hidden']);
        
        return redirect()->back()->with('success', 'Annonce masquée avec succès !');
    }

    /**
     * Admin: Activer une annonce
     */
    public function activate(Announcement $announcement)
    {
        $this->authorize('manage', $announcement);
        
        $announcement->update(['status' => 'active']);
        
        return redirect()->back()->with('success', 'Annonce activée avec succès !');
    }

    /**
     * Admin: Mettre en attente une annonce
     */
    public function pending(Announcement $announcement)
    {
        $this->authorize('manage', $announcement);
        
        $announcement->update(['status' => 'pending']);
        
        return redirect()->back()->with('success', 'Annonce mise en attente avec succès !');
    }
}
