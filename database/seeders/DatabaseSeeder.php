<?php declare(strict_types=1); 

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Créer un utilisateur admin
        User::firstOrCreate(
            ['email' => 'yandeh@gmail.com'],
            [
                'name' => 'Ndeye Yanddé Touré',
                'role' => 'admin',
                'is_active' => true,
                'password' => bcrypt('yandeh007'),
            ]
        );

        // Créer un utilisateur normal (seulement s'il n'existe pas déjà)
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'role' => 'user',
                'is_active' => true,
                'password' => bcrypt('password'),
            ]
        );

        // Créer quelques utilisateurs supplémentaires
        User::factory(5)->create([
            'role' => 'user',
            'is_active' => true,
        ]);

        // Créer un utilisateur désactivé pour tester
        User::factory()->create([
            'name' => 'Disabled User',
            'email' => 'disabled@example.com',
            'role' => 'user',
            'is_active' => false,
        ]);

        $this->call([
            CategorySeeder::class,
            AnnouncementSeeder::class,
            AdvertisementSeeder::class,
        ]);
    }
}
