<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ForumGroup;
use App\Models\ForumThread;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ForumThreadSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            return;
        }

        $threads = [
            [
                'group_slug' => 'cours-et-revisions',
                'title' => 'Bons plans révisions pour les partiels',
                'body' => "Partagez vos fiches, vos astuces de concentration et vos playlists pour réviser efficacement.\nQuels sujets reviennent souvent ?",
                'cover_image' => 'forum/examples/revisions.jpg',
            ],
            [
                'group_slug' => 'logement-et-colocation',
                'title' => 'Trouver une colocation près du campus',
                'body' => "Qui cherche une coloc proche du campus ? Partagez vos annonces et vos conseils pour visiter rapidement.",
                'cover_image' => 'forum/examples/coloc.jpg',
            ],
            [
                'group_slug' => 'opportunites-professionnelles',
                'title' => 'Stage marketing – retours d’expérience',
                'body' => "Quelle entreprise vous a le plus appris ? Où postuler pour un stage de 3 mois au Sénégal ?",
                'cover_image' => 'forum/examples/marketing.jpg',
            ],
        ];

        foreach ($threads as $data) {
            $group = ForumGroup::where('slug', $data['group_slug'])->first();
            if (!$group) {
                continue;
            }

            $slug = Str::slug($data['title']);
            $original = $slug;
            $counter = 1;
            while (ForumThread::where('slug', $slug)->exists()) {
                $slug = $original.'-'.$counter++;
            }

            ForumThread::create([
                'title' => $data['title'],
                'slug' => $slug,
                'body' => $data['body'],
                'cover_image' => $data['cover_image'],
                'user_id' => $user->id,
                'group_id' => $group->id,
                'views' => random_int(10, 120),
                'replies_count' => 0,
                'is_pinned' => false,
                'is_locked' => false,
                'last_activity_at' => now()->subHours(random_int(1, 72)),
            ]);
        }
    }
}
