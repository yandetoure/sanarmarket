<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Sanar',
                'email' => 'admin@sanar.sn',
                'password' => 'password',
                'role' => User::ROLE_ADMIN,
                'is_premium' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Utilisateur Standard',
                'email' => 'user@sanar.sn',
                'password' => 'password',
                'role' => User::ROLE_USER,
                'is_premium' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Membre Premium',
                'email' => 'premium@sanar.sn',
                'password' => 'password',
                'role' => User::ROLE_USER,
                'is_premium' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Ambassadeur Valideur',
                'email' => 'ambassador@sanar.sn',
                'password' => 'password',
                'role' => User::ROLE_AMBASSADOR,
                'is_premium' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Graphiste Designer',
                'email' => 'designer@sanar.sn',
                'password' => 'password',
                'role' => 'designer',
                'is_premium' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Responsable Marketing',
                'email' => 'marketing@sanar.sn',
                'password' => 'password',
                'role' => 'marketing',
                'is_premium' => false,
                'is_active' => true,
            ],
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
                'role' => $userData['role'],
                'is_premium' => $userData['is_premium'],
                'is_active' => $userData['is_active'],
            ]);
        }
    }
}
