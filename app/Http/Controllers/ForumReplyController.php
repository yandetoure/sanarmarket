<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ForumReply;
use App\Models\ForumThread;
use App\Models\ForumGroupMembership;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumReplyController extends Controller
{
    public function index(Request $request, ForumThread $thread)
    {
        $replies = $thread->replies()
            ->with('user')
            ->oldest()
            ->take(10)
            ->get();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'replies' => $replies->map(function ($reply) {
                    return [
                        'id' => $reply->id,
                        'body' => $reply->body,
                        'user' => [
                            'name' => $reply->user->name,
                            'initial' => strtoupper(substr($reply->user->name, 0, 1)),
                        ],
                        'created_at' => $reply->created_at->diffForHumans(),
                        'created_at_full' => $reply->created_at->format('Y-m-d H:i:s'),
                    ];
                }),
                'total' => $thread->replies_count,
            ]);
        }

        return redirect()->route('forum.show', $thread);
    }

    public function store(Request $request, ForumThread $thread)
    {
        if ($thread->is_locked) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce sujet est verrouillé.',
                ], 403);
            }
            return redirect()->route('forum.show', $thread)
                ->with('error', 'Ce sujet est verrouillé.');
        }

        $user = Auth::user();

        $membership = ForumGroupMembership::where('group_id', $thread->group_id)
            ->where('user_id', $user->id)
            ->first();

        if (!$membership || $membership->status !== ForumGroupMembership::STATUS_ACTIVE) {
            if ($membership && $membership->status === ForumGroupMembership::STATUS_BANNED) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Vous avez été banni de ce groupe.',
                    ], 403);
                }
                return redirect()->route('forum.show', $thread)
                    ->with('error', 'Vous avez été banni de ce groupe.');
            }

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rejoignez ce groupe pour participer à la discussion.',
                ], 403);
            }

            return redirect()->route('forum.show', $thread)
                ->with('error', 'Rejoignez ce groupe pour participer à la discussion.');
        }

        try {
            $validated = $request->validate([
                'body' => ['required', 'string', 'min:5'],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->validator->errors()->first('body'),
                    'errors' => $e->errors(),
                ], 422);
            }
            throw $e;
        }

        $reply = ForumReply::create([
            'thread_id' => $thread->id,
            'user_id' => $user->id,
            'body' => $validated['body'],
        ]);

        $thread->increment('replies_count');
        $thread->forceFill([
            'last_activity_at' => now(),
        ])->save();

        $reply->load('user');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Votre réponse a été publiée.',
                'reply' => [
                    'id' => $reply->id,
                    'body' => $reply->body,
                    'user' => [
                        'name' => $reply->user->name,
                        'initial' => strtoupper(substr($reply->user->name, 0, 1)),
                    ],
                    'created_at' => $reply->created_at->diffForHumans(),
                    'created_at_full' => $reply->created_at->format('Y-m-d H:i:s'),
                ],
                'thread' => [
                    'replies_count' => $thread->fresh()->replies_count,
                ],
            ]);
        }

        return redirect()
            ->route('forum.show', $thread)
            ->with('success', 'Votre réponse a été publiée.')
            ->withFragment('replies');
    }
}

