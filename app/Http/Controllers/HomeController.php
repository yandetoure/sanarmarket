<?php declare(strict_types=1); 

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\BoutiqueArticle;
use App\Models\RestaurantMenuItem;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::with(['user', 'category', 'media'])->visible()->latest();

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
        $featuredAnnouncements = Announcement::where('featured', true)->visible()->with(['user', 'category', 'media'])->take(3)->get();
        $categories = \App\Models\Category::all();

        // Récupérer les articles de boutique actifs
        $boutiqueArticles = BoutiqueArticle::with(['boutique.user', 'category'])
            ->where('status', 'active')
            ->whereHas('boutique', function($q) {
                $q->whereIn('status', ['active', 'draft']); // Inclure les boutiques actives et en brouillon
            })
            ->latest()
            ->take(6)
            ->get();

        // Récupérer les menus de restaurant actifs
        $restaurantMenuItems = RestaurantMenuItem::with(['restaurant.user'])
            ->where('is_available', true)
            ->whereHas('restaurant', function($q) {
                $q->whereIn('status', ['active', 'draft']); // Inclure les restaurants actifs et en brouillon
            })
            ->latest()
            ->take(6)
            ->get();

        // Si c'est une requête AJAX, retourner JSON
        if ($request->ajax()) {
            return response()->json([
                'announcements' => $announcements->map(function ($announcement) {
                    return [
                        'title' => $announcement->title,
                        'description' => $announcement->description,
                        'price' => $announcement->price,
                        'location' => $announcement->location,
                        'image_url' => $announcement->image_url,
                        'featured' => $announcement->featured,
                        'formatted_date' => $announcement->formatted_date,
                        'category' => [
                            'name' => $announcement->category->name,
                        ],
                        'show_url' => route('announcements.show', $announcement),
                    ];
                }),
                'count' => $announcements->count(),
            ]);
        }

        return view('home', compact('announcements', 'featuredAnnouncements', 'categories', 'boutiqueArticles', 'restaurantMenuItems'));
    }
}
