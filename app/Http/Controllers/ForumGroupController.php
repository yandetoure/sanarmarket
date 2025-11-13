<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ForumGroup;
use App\Models\ForumGroupMembership;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ForumGroupController extends Controller
{
    public function index(): View
    {
        $groups = ForumGroup::withCount(['threads', 'members'])->orderBy('name')->get();
        $userGroupIds = [];
        $bannedGroupIds = [];

        if (Auth::check()) {
            $memberships = Auth::user()->forumGroupMemberships()->select('group_id', 'status')->get();
            $userGroupIds = $memberships->where('status', ForumGroupMembership::STATUS_ACTIVE)->pluck('group_id')->toArray();
            $bannedGroupIds = $memberships->where('status', ForumGroupMembership::STATUS_BANNED)->pluck('group_id')->toArray();
        }

        return view('forum.groups.index', compact('groups', 'userGroupIds', 'bannedGroupIds'));
    }

    public function create(): View
    {
        return view('forum.groups.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:600'],
            'rules' => ['nullable', 'string'],
            'is_private' => ['sometimes', 'boolean'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
        ]);

        $slugBase = Str::slug($validated['name']);
        if ($slugBase === '') {
            $slugBase = 'groupe';
        }

        $slug = $slugBase;
        $counter = 1;
        while (ForumGroup::where('slug', $slug)->exists()) {
            $slug = $slugBase.'-'.$counter++;
        }

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('forum/group-covers', 'public');
        }

        $group = ForumGroup::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'rules' => $validated['rules'] ?? null,
            'cover_image' => $coverPath,
            'is_private' => (bool) ($validated['is_private'] ?? false),
            'owner_id' => $request->user()->id,
        ]);

        ForumGroupMembership::updateOrCreate(
            [
                'group_id' => $group->id,
                'user_id' => $request->user()->id,
            ],
            [
                'role' => 'owner',
                'status' => ForumGroupMembership::STATUS_ACTIVE,
            ],
        );

        return redirect()->route('forum.groups.show', $group)
            ->with('success', 'Groupe créé avec succès.');
    }

    public function show(ForumGroup $group): View
    {
        // Charger les compteurs pour les threads
        $group->loadCount('threads');
        
        // Calculer le nombre de membres actifs directement
        $membersCount = $group->memberships()
            ->where('status', ForumGroupMembership::STATUS_ACTIVE)
            ->count();
        
        // Ajouter le compteur manuellement au modèle
        $group->setAttribute('members_count', $membersCount);
        
        $threads = $group->threads()->with('user')
            ->orderByDesc('is_pinned')
            ->orderByDesc('last_activity_at')
            ->orderByDesc('created_at')
            ->paginate(10);
        $user = Auth::user();
        $membership = null;
        $isOwner = false;

        if ($user) {
            $membership = ForumGroupMembership::where('group_id', $group->id)
                ->where('user_id', $user->id)
                ->first();
            $isOwner = $group->owner_id === $user->id;
        }

        $isMember = $membership && $membership->status === ForumGroupMembership::STATUS_ACTIVE;
        $isBanned = $membership && $membership->status === ForumGroupMembership::STATUS_BANNED;

        if ($isOwner) {
            $isMember = true;
        }

        $activeMembers = collect();
        $bannedMembers = collect();

        if ($isOwner) {
            $activeMembers = $group->memberships()
                ->with('user')
                ->where('status', ForumGroupMembership::STATUS_ACTIVE)
                ->orderBy('created_at')
                ->get();

            $bannedMembers = $group->memberships()
                ->with('user')
                ->where('status', ForumGroupMembership::STATUS_BANNED)
                ->orderByDesc('updated_at')
                ->get();
        }

        return view('forum.groups.show', [
            'group' => $group,
            'threads' => $threads,
            'isMember' => $isMember,
            'isBanned' => $isBanned,
            'isOwner' => $isOwner,
            'activeMembers' => $activeMembers,
            'bannedMembers' => $bannedMembers,
        ]);
    }

    public function edit(ForumGroup $group): View
    {
        $this->authorizeOwner($group);

        return view('forum.groups.edit', compact('group'));
    }

    public function update(Request $request, ForumGroup $group): RedirectResponse
    {
        $this->authorizeOwner($group);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:600'],
            'rules' => ['nullable', 'string'],
            'is_private' => ['sometimes', 'boolean'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
            'remove_cover' => ['sometimes', 'boolean'],
        ]);

        $data = [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'rules' => $validated['rules'] ?? null,
            'is_private' => (bool) ($validated['is_private'] ?? false),
        ];

        if ($group->name !== $validated['name']) {
            $slugBase = Str::slug($validated['name']) ?: 'groupe';
            $slug = $slugBase;
            $counter = 1;
            while (ForumGroup::where('slug', $slug)->where('id', '!=', $group->id)->exists()) {
                $slug = $slugBase.'-'.$counter++;
            }
            $data['slug'] = $slug;
        }

        if ($request->boolean('remove_cover') && $group->cover_image) {
            Storage::disk('public')->delete($group->cover_image);
            $data['cover_image'] = null;
        }

        if ($request->hasFile('cover_image')) {
            if ($group->cover_image) {
                Storage::disk('public')->delete($group->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('forum/group-covers', 'public');
        }

        $group->update($data);

        return redirect()->route('forum.groups.show', $group)
            ->with('success', 'Paramètres du groupe mis à jour.');
    }

    public function join(ForumGroup $group, Request $request): RedirectResponse
    {
        $user = $request->user();

        $membership = ForumGroupMembership::where('group_id', $group->id)
            ->where('user_id', $user->id)
            ->first();

        if ($membership) {
            if ($membership->status === ForumGroupMembership::STATUS_BANNED) {
                return redirect()->back()->with('error', 'Vous avez été banni de ce groupe.');
            }

            if ($membership->status === ForumGroupMembership::STATUS_ACTIVE) {
                return redirect()->back()->with('info', 'Vous êtes déjà membre de ce groupe.');
            }
        }

        ForumGroupMembership::updateOrCreate(
            [
                'group_id' => $group->id,
                'user_id' => $user->id,
            ],
            [
                'role' => 'member',
                'status' => ForumGroupMembership::STATUS_ACTIVE,
            ],
        );

        return redirect()->back()->with('success', 'Vous avez rejoint le groupe.');
    }

    public function banMember(Request $request, ForumGroup $group, User $member): RedirectResponse
    {
        $this->authorizeOwner($group);

        if ($member->id === $group->owner_id) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas vous bannir vous-même.');
        }

        $membership = ForumGroupMembership::where('group_id', $group->id)
            ->where('user_id', $member->id)
            ->first();

        if (!$membership) {
            return redirect()->back()->with('error', 'Ce membre n\'appartient pas au groupe.');
        }

        $membership->update([
            'status' => ForumGroupMembership::STATUS_BANNED,
        ]);

        return redirect()->back()->with('success', "{$member->name} a été banni du groupe.");
    }

    public function unbanMember(Request $request, ForumGroup $group, User $member): RedirectResponse
    {
        $this->authorizeOwner($group);

        $membership = ForumGroupMembership::where('group_id', $group->id)
            ->where('user_id', $member->id)
            ->first();

        if (!$membership) {
            return redirect()->back()->with('error', 'Ce membre n\'appartient pas au groupe.');
        }

        $membership->update([
            'status' => ForumGroupMembership::STATUS_ACTIVE,
        ]);

        return redirect()->back()->with('success', "{$member->name} a été réintégré dans le groupe.");
    }

    protected function authorizeOwner(ForumGroup $group): void
    {
        if (Auth::id() !== $group->owner_id) {
            abort(403);
        }
    }
}

