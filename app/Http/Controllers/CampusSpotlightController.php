<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\CampusSpotlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class CampusSpotlightController extends Controller
{
    public function index()
    {
        $spotlights = CampusSpotlight::where('is_active', true)
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->with('user')
            ->get();

        return view('campus-spotlight.index', compact('spotlights'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAmbassador()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|string|in:info,ag,opening,other',
        ]);

        $spotlight = CampusSpotlight::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'is_active' => true,
            'published_at' => now(),
        ]);

        // TODO: Envoyer une notification push à tous les utilisateurs
        // Notification::send(User::all(), new CampusSpotlightNotification($spotlight));

        return redirect()->route('campus-spotlight.index')->with('success', 'Information publiée avec succès');
    }

    public function update(Request $request, CampusSpotlight $campusSpotlight)
    {
        if (!Auth::user()->isAmbassador()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|string|in:info,ag,opening,other',
        ]);

        $campusSpotlight->update([
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
        ]);

        // TODO: Envoyer une notification push si changement
        // Notification::send(User::all(), new CampusSpotlightUpdatedNotification($campusSpotlight));

        return redirect()->route('campus-spotlight.index')->with('success', 'Information mise à jour avec succès');
    }

    public function destroy(CampusSpotlight $campusSpotlight)
    {
        if (!Auth::user()->isAmbassador()) {
            abort(403);
        }

        $campusSpotlight->update(['is_active' => false]);

        return redirect()->route('campus-spotlight.index')->with('success', 'Information désactivée');
    }
}
