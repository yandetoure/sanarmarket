<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CampusRestaurantMenu;
use App\Models\User;
use Illuminate\Database\Seeder;

class CampusRestaurantMenuSeeder extends Seeder
{
    public function run(): void
    {
        $ambassador = User::where('role', 'ambassador')->first();
        
        if (!$ambassador) {
            return;
        }

        $today = now()->toDateString();

        // Restau 1 - Déjeuner
        CampusRestaurantMenu::updateOrCreate(
            [
                'restaurant_name' => CampusRestaurantMenu::RESTAURANT_1,
                'meal_type' => CampusRestaurantMenu::MEAL_DEJEUNER,
                'menu_date' => $today,
            ],
            [
                'menu_content' => 'Riz au poisson, Yassa poulet, Thieboudienne, Salade verte, Fruit de saison',
                'opening_time' => '11:30',
                'closing_time' => '14:30',
                'user_id' => $ambassador->id,
            ]
        );

        // Restau 1 - Dîner
        CampusRestaurantMenu::updateOrCreate(
            [
                'restaurant_name' => CampusRestaurantMenu::RESTAURANT_1,
                'meal_type' => CampusRestaurantMenu::MEAL_DINER,
                'menu_date' => $today,
            ],
            [
                'menu_content' => 'Mafé, Riz gras, Soupe de légumes, Pain, Boisson',
                'opening_time' => '18:00',
                'closing_time' => '20:30',
                'user_id' => $ambassador->id,
            ]
        );

        // Restau 2 - Déjeuner
        CampusRestaurantMenu::updateOrCreate(
            [
                'restaurant_name' => CampusRestaurantMenu::RESTAURANT_2,
                'meal_type' => CampusRestaurantMenu::MEAL_DEJEUNER,
                'menu_date' => $today,
            ],
            [
                'menu_content' => 'Poulet braisé, Riz blanc, Sauce tomate, Légumes vapeur, Dessert',
                'opening_time' => '12:00',
                'closing_time' => '15:00',
                'user_id' => $ambassador->id,
            ]
        );

        // Restau 2 - Dîner
        CampusRestaurantMenu::updateOrCreate(
            [
                'restaurant_name' => CampusRestaurantMenu::RESTAURANT_2,
                'meal_type' => CampusRestaurantMenu::MEAL_DINER,
                'menu_date' => $today,
            ],
            [
                'menu_content' => 'Poisson grillé, Riz au gras, Salade, Pain, Thé',
                'opening_time' => '18:30',
                'closing_time' => '21:00',
                'user_id' => $ambassador->id,
            ]
        );
    }
}
