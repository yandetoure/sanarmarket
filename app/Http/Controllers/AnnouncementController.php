<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AnnouncementMedia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::with(['user', 'category', 'subcategory', 'media'])
            ->where('validation_status', 'approved')
            ->visible()
            ->latest();

        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('subcategory') && $request->subcategory !== 'all') {
            $query->whereHas('subcategory', function ($q) use ($request) {
                $q->where('slug', $request->subcategory);
            });
        }

        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $announcements = $query->paginate(12);
        $categories = \App\Models\Category::with('announcements')->get();
        $subcategories = \App\Models\SubCategory::all();

        return view('announcements.index', compact('announcements', 'categories', 'subcategories'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        $subcategories = \App\Models\SubCategory::all();
        $user = Auth::user();

        return view('announcements.create', [
            'categories' => $categories,
            'subcategories' => $subcategories,
            'mediaLimit' => $this->mediaLimit($user),
            'canUploadVideo' => $this->canUploadVideo($user),
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        // Check announcement limit
        $currentCount = $user->announcements()->whereIn('status', ['active', 'pending'])->count();
        if ($currentCount >= $user->maxAnnouncementsLimit()) {
            return redirect()->back()->with('error', 'Vous avez atteint la limite d\'annonces (' . $user->maxAnnouncementsLimit() . ') pour votre plan actuel. Veuillez mettre à niveau votre abonnement pour en ajouter plus.');
        }

        $validated = $request->validate(array_merge([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'location' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
        ], $this->mediaRules($user, true)));

        $validated['user_id'] = $user->id;
        $validated['validation_status'] = 'pending'; // Les annonces doivent être validées
        $mediaFiles = $this->normalizeMediaFiles($request->file('media'));
        unset($validated['media']);
        if (count($mediaFiles) > $this->mediaLimit($user)) {
            throw ValidationException::withMessages([
                'media' => "Vous pouvez ajouter au maximum {$this->mediaLimit($user)} fichiers pour votre annonce.",
            ]);
        }

        $announcement = Announcement::create($validated);
        $this->storeMediaFiles($announcement, $mediaFiles);

        return redirect()->route('announcements.index')->with('success', 'Annonce créée avec succès ! Elle sera visible après validation par un modérateur.');
    }

    public function show(Announcement $announcement)
    {
        if (!$announcement->isActive() && !Auth::user()?->isAdmin()) {
            abort(404);
        }

        $announcement->load(['user', 'category', 'media']);

        return view('announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        $this->authorize('update', $announcement);

        $categories = \App\Models\Category::all();
        $subcategories = \App\Models\SubCategory::all();
        $user = Auth::user();

        return view('announcements.edit', [
            'announcement' => $announcement->loadMissing('media'),
            'categories' => $categories,
            'subcategories' => $subcategories,
            'mediaLimit' => $this->mediaLimit($user),
            'canUploadVideo' => $this->canUploadVideo($user),
        ]);
    }

    public function update(Request $request, Announcement $announcement)
    {
        $this->authorize('update', $announcement);

        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        $validated = $request->validate(array_merge([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'location' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'removed_media' => 'nullable|array',
            'removed_media.*' => 'integer|exists:announcement_media,id',
        ], $this->mediaRules($user, false)));

        $this->removeAnnouncementMedia($announcement, $request->input('removed_media', []));

        $incomingMedia = $this->normalizeMediaFiles($request->file('media'));
        unset($validated['media'], $validated['removed_media']);
        $this->assertMediaLimit($announcement, $user, count($incomingMedia));

        $announcement->update($validated);

        if (!empty($incomingMedia)) {
            $this->storeMediaFiles($announcement, $incomingMedia);
        }

        return redirect()->route('announcements.show', $announcement)->with('success', 'Annonce mise à jour avec succès !');
    }

    public function destroy(Announcement $announcement)
    {
        $this->authorize('delete', $announcement);

        $this->deleteAllMediaFiles($announcement);
        $announcement->delete();

        return redirect()->route('announcements.index')->with('success', 'Annonce supprimée avec succès !');
    }

    public function hide(Announcement $announcement)
    {
        $this->authorize('manage', $announcement);

        $announcement->update(['status' => 'hidden']);

        return redirect()->back()->with('success', 'Annonce masquée avec succès !');
    }

    public function activate(Announcement $announcement)
    {
        $this->authorize('manage', $announcement);

        $announcement->update(['status' => 'active']);

        return redirect()->back()->with('success', 'Annonce activée avec succès !');
    }

    public function pending(Announcement $announcement)
    {
        $this->authorize('manage', $announcement);

        $announcement->update(['status' => 'pending']);

        return redirect()->back()->with('success', 'Annonce mise en attente avec succès !');
    }

    public function apiIndex(Request $request)
    {
        $query = Announcement::with(['user', 'category', 'media'])->visible()->latest();

        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $announcements = $query->paginate(12);

        return response()->json($announcements);
    }

    public function apiShow($id)
    {
        $announcement = Announcement::with(['user', 'category', 'media'])->findOrFail($id);

        if (!$announcement->isActive() && !Auth::user()?->isAdmin()) {
            return response()->json(['message' => 'Annonce non trouvée'], 404);
        }

        return response()->json($announcement);
    }

    public function apiStore(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        // Check announcement limit
        $currentCount = $user->announcements()->whereIn('status', ['active', 'pending'])->count();
        if ($currentCount >= $user->maxAnnouncementsLimit()) {
            return response()->json([
                'message' => 'Limite d\'annonces atteinte',
                'errors' => [
                    'limit' => ['Vous avez atteint la limite d\'annonces (' . $user->maxAnnouncementsLimit() . ') pour votre plan actuel.']
                ]
            ], 403);
        }

        $validated = $request->validate(array_merge([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'location' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
        ], $this->mediaRules($user, true)));

        $validated['user_id'] = $user->id;
        $validated['validation_status'] = 'pending'; // Les annonces doivent être validées
        $mediaFiles = $this->normalizeMediaFiles($request->file('media'));
        unset($validated['media']);

        $announcement = Announcement::create($validated);
        $this->storeMediaFiles($announcement, $mediaFiles);

        $announcement->load(['user', 'category', 'subcategory', 'media']);

        return response()->json($announcement, 201);
    }

    public function apiUpdate(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);
        $this->authorize('update', $announcement);

        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        $validated = $request->validate(array_merge([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'location' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'removed_media' => 'nullable|array',
            'removed_media.*' => 'integer|exists:announcement_media,id',
        ], $this->mediaRules($user, false)));

        $this->removeAnnouncementMedia($announcement, $request->input('removed_media', []));

        $incomingMedia = $this->normalizeMediaFiles($request->file('media'));
        unset($validated['media'], $validated['removed_media']);
        $this->assertMediaLimit($announcement, $user, count($incomingMedia));

        $announcement->update($validated);

        if (!empty($incomingMedia)) {
            $this->storeMediaFiles($announcement, $incomingMedia);
        }

        $announcement->load(['user', 'category', 'media']);

        return response()->json($announcement);
    }

    public function apiDestroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $this->authorize('delete', $announcement);

        $this->deleteAllMediaFiles($announcement);
        $announcement->delete();

        return response()->json(['message' => 'Annonce supprimée avec succès'], 200);
    }

    private function mediaLimit(?User $user): int
    {
        return $user?->mediaUploadLimit() ?? 3;
    }

    private function canUploadVideo(?User $user): bool
    {
        return $user?->canUploadVideo() ?? false;
    }

    /**
     * @return array<string, array<int, string>>
     */
    private function mediaRules(?User $user, bool $required): array
    {
        $limit = $this->mediaLimit($user);
        $mediaRule = $required ? ['required', 'array', 'min:1'] : ['sometimes', 'nullable', 'array'];
        $mediaRule[] = 'max:' . $limit;

        $mimes = $this->canUploadVideo($user)
            ? 'mimetypes:image/jpeg,image/png,image/jpg,image/gif,video/mp4,video/quicktime,video/x-msvideo'
            : 'mimetypes:image/jpeg,image/png,image/jpg,image/gif';

        return [
            'media' => $mediaRule,
            'media.*' => ['file', 'max:20480', $mimes],
        ];
    }

    private function assertMediaLimit(Announcement $announcement, User $user, int $incomingCount): void
    {
        $current = $announcement->media()->count();
        $limit = $this->mediaLimit($user);

        if ($current + $incomingCount > $limit) {
            throw ValidationException::withMessages([
                'media' => "Vous pouvez ajouter au maximum {$limit} fichiers pour votre annonce.",
            ]);
        }
    }

    /**
     * @param array<int, UploadedFile> $files
     */
    private function storeMediaFiles(Announcement $announcement, array $files): void
    {
        if (empty($files)) {
            return;
        }

        $position = ($announcement->media()->max('position') ?? -1) + 1;

        foreach ($files as $file) {
            if (!$file instanceof UploadedFile) {
                continue;
            }

            $path = $file->store('announcements/media', 'public');
            $type = str_starts_with($file->getMimeType() ?? '', 'video/')
                ? AnnouncementMedia::TYPE_VIDEO
                : AnnouncementMedia::TYPE_IMAGE;

            $announcement->media()->create([
                'path' => $path,
                'type' => $type,
                'position' => $position++,
            ]);
        }

        $this->refreshCoverImage($announcement);
    }

    private function removeAnnouncementMedia(Announcement $announcement, array $mediaIds): void
    {
        if (empty($mediaIds)) {
            return;
        }

        $mediaItems = $announcement->media()->whereIn('id', $mediaIds)->get();

        foreach ($mediaItems as $media) {
            if ($media->path && Storage::disk('public')->exists($media->path)) {
                Storage::disk('public')->delete($media->path);
            }
            $media->delete();
        }

        $this->refreshCoverImage($announcement);
    }

    private function refreshCoverImage(Announcement $announcement): void
    {
        $firstImage = $announcement->media()
            ->where('type', AnnouncementMedia::TYPE_IMAGE)
            ->orderBy('position')
            ->first();

        $announcement->update(['image' => $firstImage?->path]);
    }

    private function deleteAllMediaFiles(Announcement $announcement): void
    {
        $announcement->loadMissing('media');

        foreach ($announcement->media as $media) {
            if ($media->path && Storage::disk('public')->exists($media->path)) {
                Storage::disk('public')->delete($media->path);
            }
        }

        if ($announcement->image && Storage::disk('public')->exists($announcement->image)) {
            Storage::disk('public')->delete($announcement->image);
        }
    }

    /**
     * @param mixed $files
     * @return array<int, UploadedFile>
     */
    private function normalizeMediaFiles($files): array
    {
        if (!$files) {
            return [];
        }

        if ($files instanceof UploadedFile) {
            return [$files];
        }

        if (!is_array($files)) {
            return [];
        }

        return array_values(array_filter($files, fn($file) => $file instanceof UploadedFile));
    }
}
