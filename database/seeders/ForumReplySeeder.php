<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ForumReply;
use App\Models\ForumThread;
use App\Models\User;
use Illuminate\Database\Seeder;

class ForumReplySeeder extends Seeder
{
    public function run(): void
    {
        $user = User::skip(1)->first();
        if (!$user) {
            return;
        }

        ForumThread::limit(3)->get()->each(function (ForumThread $thread) use ($user) {
            ForumReply::create([
                'thread_id' => $thread->id,
                'user_id' => $user->id,
                'body' => 'Merci pour le partage ! Je note cette info et je reviens avec mon expérience.',
            ]);

            ForumReply::create([
                'thread_id' => $thread->id,
                'user_id' => $user->id,
                'body' => 'Est-ce que vous avez essayé la ressource mentionnée ? J’ai quelques questions sur le timing.',
                'created_at' => now()->subHours(2),
            ]);
        });
    }
}
