<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $taxonomies = [
            'Immobilier' => [
                'Appartements',
                'Maisons',
                'Terrains',
                'Bureaux & Commerces',
            ],
            'Véhicules' => [
                'Voitures',
                'Motos & Scooters',
                'Équipements Auto',
                'Vélos',
            ],
            'Électronique' => [
                'Téléphones',
                'Ordinateurs',
                'Tablettes',
                'Télévisions',
                'Accessoires',
            ],
            'Mode & Beauté' => [
                'Vêtements',
                'Chaussures',
                'Montres & Bijoux',
                'Produits de beauté',
            ],
            'Maison & Jardin' => [
                'Meubles',
                'Électroménager',
                'Décoration',
                'Bricolage',
            ],
            'Emploi & Services' => [
                'Offres d\'emploi',
                'Services à la personne',
                'Cours particuliers',
                'Informatique & Multimedia',
            ],
        ];

        foreach ($taxonomies as $categoryName => $subcategories) {
            $category = Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'description' => "Catégorie principale pour $categoryName",
            ]);

            foreach ($subcategories as $subName) {
                SubCategory::create([
                    'category_id' => $category->id,
                    'name' => $subName,
                    'slug' => Str::slug($subName),
                    'description' => "Sous-catégorie pour $subName",
                ]);
            }
        }
    }
}
