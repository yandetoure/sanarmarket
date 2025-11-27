<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Boutique;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        $announcementQuery = Announcement::with(['category', 'media'])
            ->where('user_id', $user->id)
            ->latest();

        $announcements = (clone $announcementQuery)->take(6)->get();

        $stats = [
            'total' => $announcementQuery->count(),
            'active' => Announcement::where('user_id', $user->id)->where('status', 'active')->count(),
            'pending' => Announcement::where('user_id', $user->id)->where('status', 'pending')->count(),
            'featured' => Announcement::where('user_id', $user->id)->where('featured', true)->count(),
        ];

        $boutiques = Boutique::withCount(['articles', 'categories'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(4)
            ->get();

        $restaurants = Restaurant::withCount(['menuItems', 'schedules'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(4)
            ->get();

        return view('dashboard.index', [
            'user' => $user,
            'announcements' => $announcements,
            'stats' => $stats,
            'boutiques' => $boutiques,
            'restaurants' => $restaurants,
        ]);
    }

    public function myAnnouncements()
    {
        $user = Auth::user();

        $announcements = Announcement::with(['category', 'media'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(12);

        $stats = [
            'total' => Announcement::where('user_id', $user->id)->count(),
            'active' => Announcement::where('user_id', $user->id)->where('status', 'active')->count(),
            'pending' => Announcement::where('user_id', $user->id)->where('status', 'pending')->count(),
            'featured' => Announcement::where('user_id', $user->id)->where('featured', true)->count(),
            'total_boutiques' => Boutique::where('user_id', $user->id)->count(),
            'total_restaurants' => Restaurant::where('user_id', $user->id)->count(),
        ];

        return view('dashboard.announcements', [
            'user' => $user,
            'announcements' => $announcements,
            'stats' => $stats,
        ]);
    }
}

