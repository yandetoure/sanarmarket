<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Livres',
                'slug' => 'livres',
                'icon' => 'BookOpen',
                'description' => 'Manuels, romans, livres de cours et ouvrages académiques',
            ],
            [
                'name' => 'Fournitures',
                'slug' => 'fournitures',
                'icon' => 'PenTool',
                'description' => 'Cahiers, stylos, calculatrices et matériel scolaire',
            ],
            [
                'name' => 'Hygiène & Savons',
                'slug' => 'hygiene',
                'icon' => 'Droplet',
                'description' => 'Produits d\'hygiène, savons et cosmétiques',
            ],
            [
                'name' => 'Électronique',
                'slug' => 'electronique',
                'icon' => 'Laptop',
                'description' => 'Ordinateurs, téléphones, accessoires électroniques',
            ],
            [
                'name' => 'Vêtements',
                'slug' => 'vetements',
                'icon' => 'ShoppingBag',
                'description' => 'Vêtements, chaussures et accessoires de mode',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
