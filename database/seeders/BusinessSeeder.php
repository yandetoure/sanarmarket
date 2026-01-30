<?php

namespace Database\Seeders;

use App\Models\Boutique;
use App\Models\BoutiqueCategory;
use App\Models\BoutiqueArticle;
use App\Models\Restaurant;
use App\Models\RestaurantMenuItem;
use App\Models\RestaurantSchedule;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BusinessSeeder extends Seeder
{
    public function run(): void
    {
        $manager = User::where('email', 'manager@sanar.sn')->first();
        if (!$manager)
            return;

        // --- BOUTIQUES ---
        $boutique = Boutique::create([
            'user_id' => $manager->id,
            'name' => 'Sanar Tech Store',
            'slug' => 'sanar-tech-store',
            'description' => 'La meilleure boutique de gadgets et informatique pour les étudiants.',
            'address' => 'Campus Sanar, Près du Restau 2',
            'phone' => '+221 77 123 45 67',
            'status' => 'active',
            'validation_status' => 'approved',
            'is_subscribed' => true,
        ]);

        $techCategory = BoutiqueCategory::create([
            'boutique_id' => $boutique->id,
            'name' => 'Accessoires PC',
            'slug' => 'accessoires-pc',
        ]);

        BoutiqueArticle::create([
            'boutique_id' => $boutique->id,
            'boutique_category_id' => $techCategory->id,
            'name' => 'Souris Sans Fil Logitech',
            'slug' => 'souris-sans-fil-logitech',
            'description' => 'Souris optique de haute précision pour laptops.',
            'price' => 7500,
            'stock' => 15,
            'status' => 'active',
        ]);

        // --- RESTAURANTS ---
        $restaurant = Restaurant::create([
            'user_id' => $manager->id,
            'name' => 'Le Gourmet Sanarois',
            'slug' => 'le-gourmet-sanarois',
            'description' => 'Spécialités locales et plats du jour exquis.',
            'address' => 'Avenue du Campus, Saint-Louis',
            'phone' => '+221 78 987 65 43',
            'status' => 'active',
            'validation_status' => 'approved',
            'is_subscribed' => true,
            'metadata' => [
                'cuisine_type' => 'Sénégalaise & Africaine',
                'price_range' => '500 - 2500 FCFA',
            ],
        ]);

        RestaurantMenuItem::create([
            'restaurant_id' => $restaurant->id,
            'title' => 'Thieboudienne Penda Mbaye',
            'slug' => 'thieboudienne-penda-mbaye',
            'description' => 'Le riz au poisson traditionnel, riche en saveurs.',
            'price' => 1200,
            'availability_type' => 'daily',
            'is_available' => true,
        ]);

        $days = [0, 1, 2, 3, 4, 5, 6];
        foreach ($days as $day) {
            RestaurantSchedule::create([
                'restaurant_id' => $restaurant->id,
                'day_of_week' => $day,
                'opens_at' => '11:00',
                'closes_at' => '22:00',
                'is_closed' => false,
            ]);
        }
    }
}
