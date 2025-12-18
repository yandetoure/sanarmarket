<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\UsefulInfo;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsefulInfoSeeder extends Seeder
{
    public function run(): void
    {
        $ambassador = User::where('role', 'ambassador')->first();
        
        if (!$ambassador) {
            return;
        }

        // Heures de prière
        UsefulInfo::updateOrCreate(
            ['type' => UsefulInfo::TYPE_PRAYER_TIMES],
            [
                'title' => 'Heures de prière',
                'data' => [
                    'fajr' => '05:45',
                    'dhuhr' => '12:30',
                    'asr' => '15:45',
                    'maghrib' => '18:20',
                    'isha' => '19:35',
                ],
                'user_id' => $ambassador->id,
                'is_active' => true,
            ]
        );

        // Contacts des services de l'université
        $contacts = [
            [
                'title' => 'Centre Médical',
                'content' => "Téléphone: +221 33 961 23 45\nEmail: medical@ugb.sn\nHoraires: Lundi-Vendredi 8h-17h\nUrgences: 24/7",
            ],
            [
                'title' => 'Bibliothèque Universitaire',
                'content' => "Téléphone: +221 33 961 23 50\nEmail: bu@ugb.sn\nHoraires: Lundi-Samedi 8h-20h\nFermé le dimanche",
            ],
            [
                'title' => 'Scolarité',
                'content' => "Téléphone: +221 33 961 23 40\nEmail: scolarite@ugb.sn\nHoraires: Lundi-Vendredi 8h-16h\nBureau: Bâtiment A, 1er étage",
            ],
        ];

        foreach ($contacts as $contact) {
            UsefulInfo::create([
                'type' => UsefulInfo::TYPE_UNIVERSITY_CONTACT,
                'title' => $contact['title'],
                'content' => $contact['content'],
                'user_id' => $ambassador->id,
                'is_active' => true,
            ]);
        }
    }
}
