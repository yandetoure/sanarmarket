<?php declare(strict_types=1); 

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class HomeController extends Controller
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

        $announcements = $query->take(12)->get();
        $featuredAnnouncements = Announcement::where('featured', true)->visible()->with(['user', 'category'])->take(3)->get();
        $categories = \App\Models\Category::all();

        return view('home', compact('announcements', 'featuredAnnouncements', 'categories'));
    }
}
