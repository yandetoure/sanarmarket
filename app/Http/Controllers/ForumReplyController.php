<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ForumReply;
use App\Models\ForumThread;
use App\Models\ForumGroupMembership;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumReplyController extends Controller
{
    public function store(Request $request, ForumThread $thread): RedirectResponse
    {
        if ($thread->is_locked) {
            return redirect()->route('forum.show', $thread)
                ->with('error', 'Ce sujet est verrouillé.');
        }

        $user = Auth::user();

        $membership = ForumGroupMembership::where('group_id', $thread->group_id)
            ->where('user_id', $user->id)
            ->first();

        if (!$membership || $membership->status !== ForumGroupMembership::STATUS_ACTIVE) {
            if ($membership && $membership->status === ForumGroupMembership::STATUS_BANNED) {
                return redirect()->route('forum.show', $thread)
                    ->with('error', 'Vous avez été banni de ce groupe.');
            }

            return redirect()->route('forum.show', $thread)
                ->with('error', 'Rejoignez ce groupe pour participer à la discussion.');
        }

        $validated = $request->validate([
            'body' => ['required', 'string', 'min:5'],
        ]);

        ForumReply::create([
            'thread_id' => $thread->id,
            'user_id' => $user->id,
            'body' => $validated['body'],
        ]);

        $thread->increment('replies_count');
        $thread->forceFill([
            'last_activity_at' => now(),
        ])->save();

        return redirect()
            ->route('forum.show', $thread)
            ->with('success', 'Votre réponse a été publiée.')
            ->withFragment('replies');
    }
}

