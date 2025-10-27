<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Advertisement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdvertisementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $advertisements = [
            [
                'title' => 'Promotion Spéciale Étudiants',
                'content' => 'Profitez de réductions exclusives sur tous nos produits ! Code promo : ETUDIANT2024',
                'type' => 'banner',
                'position' => 'hero',
                'display_duration' => 30,
                'is_active' => true,
                'link' => 'https://example.com/promotion',
            ],
            [
                'title' => 'Nouvelle Collection Automne',
                'content' => 'Découvrez notre nouvelle collection de vêtements pour la rentrée universitaire.',
                'type' => 'popup',
                'position' => 'popup',
                'display_duration' => 15,
                'popup_duration' => 5,
                'is_active' => true,
                'link' => 'https://example.com/collection',
            ],
            [
                'title' => 'Livraison Gratuite',
                'content' => 'Livraison gratuite sur toutes vos commandes de plus de 50€ !',
                'type' => 'banner',
                'position' => 'hero',
                'display_duration' => 7,
                'is_active' => false,
            ],
            [
                'title' => 'Événement Campus',
                'content' => 'Rejoignez-nous pour notre événement spécial campus le 15 novembre !',
                'type' => 'popup',
                'position' => 'popup',
                'display_duration' => 10,
                'popup_duration' => 8,
                'is_active' => true,
                'start_date' => now()->addDays(5),
                'end_date' => now()->addDays(15),
            ],
        ];

        foreach ($advertisements as $advertisementData) {
            Advertisement::create($advertisementData);
        }
    }
}