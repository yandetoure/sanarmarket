<?php declare(strict_types=1); 

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->delete();

        User::create([
            'name' => 'Ndeye Yanddé Touré',
            'email' => 'yandeh@gmail.com',
            'role' => 'admin',
            'is_active' => true,
            'password' => Hash::make('yandeh007'),
        ]);

        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'user',
            'is_active' => true,
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Disabled User',
            'email' => 'disabled@example.com',
            'role' => 'user',
            'is_active' => false,
            'password' => Hash::make('password'),
        ]);

        collect([
            ['name' => 'Aïssatou Diallo', 'email' => 'aissatou@example.com', 'role' => 'designer'],
            ['name' => 'Moussa Ndiaye', 'email' => 'moussa@example.com', 'role' => 'marketing'],
            ['name' => 'Khady Sow', 'email' => 'khady@example.com', 'role' => 'user'],
            ['name' => 'Cheikh Diop', 'email' => 'cheikh@example.com', 'role' => 'designer'],
            ['name' => 'Aminata Ba', 'email' => 'aminata@example.com', 'role' => 'marketing'],
        ])->each(function (array $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'is_active' => true,
                'password' => Hash::make('password'),
            ]);
        });

        $this->call([
            CategorySeeder::class,
            AnnouncementSeeder::class,
            AdvertisementSeeder::class,
        ]);
    }
}
