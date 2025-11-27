<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $categories = Category::all();

        $announcements = [
            [
                'title' => 'Analyse Mathématique - Tome 1 et 2',
                'description' => 'Livres de cours en excellent état, peu utilisés. Parfait pour les étudiants de L1-L2 Mathématiques.',
                'price' => '15 000 FCFA',
                'location' => 'Campus Jussieu, Paris',
                'featured' => true,
                'category_slug' => 'livres',
                'phone' => '+221 77 100 20 30',
            ],
            [
                'title' => 'Lot de cahiers et stylos',
                'description' => 'Pack complet de fournitures : 5 cahiers A4, 10 stylos (bleu, noir, rouge), surligneurs. Idéal rentrée.',
                'price' => '7 500 FCFA',
                'location' => 'Lyon',
                'featured' => false,
                'category_slug' => 'fournitures',
                'phone' => '+221 78 555 66 44',
            ],
            [
                'title' => 'Savons artisanaux bio - Lot de 6',
                'description' => 'Savons faits maison, 100% naturels et bio. Différents parfums : lavande, menthe, citron. Doux pour la peau.',
                'price' => '10 000 FCFA',
                'location' => 'Marseille',
                'featured' => true,
                'category_slug' => 'hygiene',
                'phone' => '+221 76 321 45 67',
            ],
            [
                'title' => 'MacBook Air M1 - État impeccable',
                'description' => 'MacBook Air M1 2020, 8GB RAM, 256GB SSD. Parfait pour prendre des notes et travailler. Avec chargeur.',
                'price' => '350 000 FCFA',
                'location' => 'Nice',
                'featured' => false,
                'category_slug' => 'electronique',
                'phone' => '+221 70 998 12 34',
            ],
            [
                'title' => 'Sac à dos universitaire Eastpak',
                'description' => 'Sac à dos robuste avec compartiment ordinateur. Parfait état, utilisé 1 an. Idéal pour transporter cours et PC.',
                'price' => '18 000 FCFA',
                'location' => 'Toulouse',
                'featured' => false,
                'category_slug' => 'vetements',
                'phone' => '+221 76 400 55 99',
            ],
            [
                'title' => 'Introduction à la Physique Quantique',
                'description' => 'Manuel de référence pour étudiants en physique L3/M1. Très bon état avec annotations utiles effaçables.',
                'price' => '16 000 FCFA',
                'location' => 'Bordeaux',
                'featured' => false,
                'category_slug' => 'livres',
                'phone' => '+221 77 830 44 11',
            ],
            [
                'title' => 'Calculatrice scientifique TI-83',
                'description' => 'Calculatrice graphique programmable en excellent état. Indispensable pour les maths et sciences.',
                'price' => '22 000 FCFA',
                'location' => 'Strasbourg',
                'featured' => true,
                'category_slug' => 'fournitures',
                'phone' => '+221 78 990 11 22',
            ],
            [
                'title' => 'Shampoing et gel douche bio',
                'description' => 'Produits d\'hygiène écologiques et économiques. Sans parabènes, parfum naturel. Lot de 3 bouteilles.',
                'price' => '12 000 FCFA',
                'location' => 'Nantes',
                'featured' => false,
                'category_slug' => 'hygiene',
                'phone' => '+221 70 555 77 88',
            ],
        ];

        foreach ($announcements as $index => $announcementData) {
            $category = $categories->where('slug', $announcementData['category_slug'])->first();

            // Assigner différents statuts pour tester
            $statuses = ['active', 'active', 'active', 'hidden', 'pending'];
            $status = $statuses[$index % count($statuses)];

            Announcement::create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'title' => $announcementData['title'],
                'description' => $announcementData['description'],
                'price' => $announcementData['price'],
                'location' => $announcementData['location'],
                'phone' => $announcementData['phone'],
                'featured' => $announcementData['featured'],
                'status' => $status,
                'image' => null, // Utilisera l'image par défaut de la catégorie
            ]);
        }
    }
}
