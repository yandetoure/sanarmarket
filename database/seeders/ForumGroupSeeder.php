<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ForumGroup;
use Illuminate\Database\Seeder;

class ForumGroupSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            [
                'name' => 'Cours & révisions',
                'slug' => 'cours-et-revisions',
                'description' => 'Échange de fiches, questions d’examens et conseils de méthodologie.',
                'rules' => "Respectez les droits d’auteur.\nPas de spoiler sans balise.",
            ],
            [
                'name' => 'Logement & colocation',
                'slug' => 'logement-et-colocation',
                'description' => 'Bons plans logement, annonces de colocation et avis sur les résidences.',
                'rules' => "Indiquez le budget estimé.\nRespectez la vie privée des personnes.",
            ],
            [
                'name' => 'Opportunités professionnelles',
                'slug' => 'opportunites-professionnelles',
                'description' => 'Stages, jobs et missions freelance repérés par les étudiants.',
                'rules' => "Mentionnez les dates limites.\nIncluez un contact ou un lien officiel.",
            ],
        ];

        foreach ($groups as $data) {
            ForumGroup::firstOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
