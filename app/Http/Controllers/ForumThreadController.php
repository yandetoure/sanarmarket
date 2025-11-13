<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ForumThread;
use App\Models\ForumGroup;
use App\Models\ForumGroupMembership;
use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ForumThreadController extends Controller
{
    public function index(Request $request): View
    {
        $groups = ForumGroup::withCount(['threads', 'members'])->orderBy('name')->get();
        $currentGroup = null;

        $threadsQuery = ForumThread::with(['user', 'group'])
            ->orderByDesc('is_pinned')
            ->orderByDesc('last_activity_at')
            ->orderByDesc('created_at')
            ->when($request->filled('group'), function (Builder $query) use ($request, &$currentGroup) {
                $currentGroup = ForumGroup::where('slug', $request->string('group'))->withCount(['threads', 'members'])->firstOrFail();
                $query->where('group_id', $currentGroup->id);
            });

        $threads = $threadsQuery->paginate(10)->withQueryString();

        $userGroupIds = [];
        $bannedGroupIds = [];

        if ($request->user()) {
            $memberships = $request->user()->forumGroupMemberships()->select('group_id', 'status')->get();
            $userGroupIds = $memberships->where('status', ForumGroupMembership::STATUS_ACTIVE)->pluck('group_id')->toArray();
            $bannedGroupIds = $memberships->where('status', ForumGroupMembership::STATUS_BANNED)->pluck('group_id')->toArray();
        }

        // Récupérer les publicités actives pour la sidebar
        $advertisements = Advertisement::where('is_active', true)
            ->where('type', 'banner')
            ->where(function($query) {
                $query->whereNull('start_date')
                      ->orWhere('start_date', '<=', now());
            })
            ->where(function($query) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', now());
            })
            ->inRandomOrder()
            ->take(3)
            ->get();

        // Nombre d'utilisateurs avec le rôle "user" pour le fil général
        $totalUsersCount = User::where('role', 'user')->count();

        return view('forum.index', [
            'threads' => $threads,
            'groups' => $groups,
            'currentGroup' => $currentGroup,
            'userGroupIds' => $userGroupIds,
            'bannedGroupIds' => $bannedGroupIds,
            'advertisements' => $advertisements,
            'totalUsersCount' => $totalUsersCount,
        ]);
    }

    public function create(): View
    {
        $user = Auth::user();

        $groups = $user->forumGroups()->orderBy('name')->get();

        if ($groups->isEmpty()) {
            return redirect()->route('forum.index')
                ->with('error', 'Rejoignez un groupe avant de créer un sujet.');
        }

        return view('forum.create', compact('groups'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'body' => ['required', 'string', 'min:20'],
            'group_id' => ['required', 'exists:forum_groups,id'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
        ]);

        $slugBase = Str::slug($validated['title']);
        if (empty($slugBase)) {
            $slugBase = 'sujet';
        }
        $slug = $slugBase;
        $counter = 1;

        while (ForumThread::where('slug', $slug)->exists()) {
            $slug = $slugBase.'-'.$counter++;
        }

        $user = Auth::user();

        $isMember = $user->forumGroupMemberships()
            ->where('group_id', $validated['group_id'])
            ->where('status', ForumGroupMembership::STATUS_ACTIVE)
            ->exists();

        if (!$isMember) {
            return redirect()->route('forum.index')
                ->with('error', 'Vous devez rejoindre ce groupe pour publier.');
        }

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('forum/threads', 'public');
        }

        $thread = ForumThread::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'body' => $validated['body'],
            'cover_image' => $coverPath,
            'user_id' => $user->id,
            'group_id' => $validated['group_id'],
            'last_activity_at' => now(),
        ]);

        return redirect()->route('forum.show', $thread)
            ->with('success', 'Sujet publié avec succès.');
    }

    public function show(ForumThread $thread): View
    {
        $thread->increment('views');
        $thread->load(['user', 'group']);

        $membership = null;
        $isOwner = false;
        $isMember = false;
        $isBanned = false;

        if (Auth::check()) {
            $membership = ForumGroupMembership::where('group_id', $thread->group_id)
                ->where('user_id', Auth::id())
                ->first();
            if ($membership) {
                $isMember = $membership->status === ForumGroupMembership::STATUS_ACTIVE;
                $isBanned = $membership->status === ForumGroupMembership::STATUS_BANNED;
            }
            $isOwner = $thread->group && $thread->group->owner_id === Auth::id();
        }

        return view('forum.show', [
            'thread' => $thread,
            'replies' => $thread->replies()->with('user')->oldest()->paginate(15),
            'isMember' => $isMember,
            'isBanned' => $isBanned,
            'isOwner' => $isOwner,
        ]);
    }
}

