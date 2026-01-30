<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Models\ForumGroup;
use App\Models\ForumGroupMembership;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->delete();

        User::create([
            'name' => 'Ndeye Yanddé Touré',
            'email' => 'yandeh@gmail.com',
            'role' => 'admin',
            'is_active' => true,
            'password' => Hash::make('yandeh007'),
        ]);

        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'user',
            'is_active' => true,
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Disabled User',
            'email' => 'disabled@example.com',
            'role' => 'user',
            'is_active' => false,
            'password' => Hash::make('password'),
        ]);

        // Créer un ambassadeur
        User::create([
            'name' => 'Amadou Ba',
            'email' => 'ambassador@example.com',
            'role' => 'ambassador',
            'is_active' => true,
            'password' => Hash::make('password'),
        ]);

        // Créer un modérateur
        User::create([
            'name' => 'Fatou Diallo',
            'email' => 'moderator@example.com',
            'role' => 'moderator',
            'is_active' => true,
            'password' => Hash::make('password'),
        ]);

        $extraUsers = collect([
            ['name' => 'Aïssatou Diallo', 'email' => 'aissatou@example.com', 'role' => 'designer'],
            ['name' => 'Moussa Ndiaye', 'email' => 'moussa@example.com', 'role' => 'marketing'],
            ['name' => 'Khady Sow', 'email' => 'khady@example.com', 'role' => 'user'],
            ['name' => 'Cheikh Diop', 'email' => 'cheikh@example.com', 'role' => 'designer'],
            ['name' => 'Aminata Ba', 'email' => 'aminata@example.com', 'role' => 'marketing'],
        ]);

        $extraUsers->each(function (array $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'is_active' => true,
                'password' => Hash::make('password'),
            ]);
        });

        $admin = User::where('email', 'yandeh@gmail.com')->first();

        $groups = collect([
            [
                'name' => 'Logement & colocation',
                'slug' => 'logement-et-colocation',
                'description' => 'Partagez vos bons plans logement, colocations et astuces pour bien s\'installer près du campus.',
                'rules' => "Indiquez le budget estimé.\nRespectez la vie privée des personnes.",
                'owner_id' => optional($admin)->id,
            ],
            [
                'name' => 'Cours & révisions',
                'slug' => 'cours-et-revisions',
                'description' => 'Échangez vos fiches de révision, posez des questions de cours et préparez vos examens ensemble.',
                'rules' => "Respectez les droits d'auteur.\nPas de spoiler sans balise.",
                'owner_id' => optional($admin)->id,
            ],
            [
                'name' => 'Opportunités professionnelles',
                'slug' => 'opportunites-professionnelles',
                'description' => 'Stages, alternances, jobs étudiants ou missions freelance : partagez et trouvez vos missions.',
                'rules' => "Mentionnez les dates limites.\nIncluez un contact ou un lien officiel.",
                'owner_id' => optional($admin)->id,
            ],
        ])->map(fn(array $data) => ForumGroup::updateOrCreate(['slug' => $data['slug']], $data));

        if ($admin) {
            foreach ($groups as $group) {
                ForumGroupMembership::updateOrCreate(
                    [
                        'group_id' => $group->id,
                        'user_id' => $admin->id,
                    ],
                    [
                        'role' => 'owner',
                        'status' => ForumGroupMembership::STATUS_ACTIVE,
                    ],
                );
            }
        }

        $extraUsers->each(function (array $user) use ($groups) {
            $userModel = User::where('email', $user['email'])->first();
            if ($userModel) {
                $groupId = $groups->random()->id;
                ForumGroupMembership::updateOrCreate(
                    [
                        'group_id' => $groupId,
                        'user_id' => $userModel->id,
                    ],
                    [
                        'role' => 'member',
                        'status' => ForumGroupMembership::STATUS_ACTIVE,
                    ],
                );
            }
        });

        $this->call([
            ForumGroupSeeder::class,
            ForumThreadSeeder::class,
            ForumReplySeeder::class,
            CategorySeeder::class,
            AnnouncementSeeder::class,
            AdvertisementSeeder::class,
            CampusSpotlightSeeder::class,
            CampusRestaurantMenuSeeder::class,
            UsefulInfoSeeder::class,
        ]);
    }
}
