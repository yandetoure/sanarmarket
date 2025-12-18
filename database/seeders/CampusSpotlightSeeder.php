<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CampusSpotlight;
use App\Models\User;
use Illuminate\Database\Seeder;

class CampusSpotlightSeeder extends Seeder
{
    public function run(): void
    {
        $ambassador = User::where('role', 'ambassador')->first();
        
        if (!$ambassador) {
            return;
        }

        CampusSpotlight::create([
            'user_id' => $ambassador->id,
            'title' => 'Assemblée Générale des Étudiants',
            'content' => 'L\'assemblée générale des étudiants aura lieu le 20 décembre 2024 à 14h00 dans l\'amphithéâtre principal. Ordre du jour : élection du nouveau bureau, budget étudiant, et projets pour l\'année 2025.',
            'type' => 'ag',
            'is_active' => true,
            'published_at' => now(),
        ]);

        CampusSpotlight::create([
            'user_id' => $ambassador->id,
            'title' => 'Ouverture du Campus - Rentrée 2025',
            'content' => 'Le campus rouvre ses portes le 15 janvier 2025. Les inscriptions sont ouvertes jusqu\'au 10 janvier. Tous les services (scolarité, bibliothèque, restaurant) seront opérationnels dès le premier jour.',
            'type' => 'opening',
            'is_active' => true,
            'published_at' => now()->subDays(2),
        ]);

        CampusSpotlight::create([
            'user_id' => $ambassador->id,
            'title' => 'Nouvelle bibliothèque numérique',
            'content' => 'Accès gratuit à plus de 10 000 ouvrages numériques pour tous les étudiants. Connectez-vous avec vos identifiants universitaires sur le portail étudiant.',
            'type' => 'info',
            'is_active' => true,
            'published_at' => now()->subDays(5),
        ]);
    }
}
