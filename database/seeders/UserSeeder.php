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
                'role' => 'admin',
                'is_active' => true,
            ],
            [
                'name' => 'Utilisateur Standard',
                'email' => 'user@sanar.sn',
                'password' => 'password',
                'role' => 'user',
                'is_active' => true,
            ],
            [
                'name' => 'Membre Premium',
                'email' => 'premium@sanar.sn',
                'password' => 'password',
                'role' => 'premium',
                'is_active' => true,
            ],
            [
                'name' => 'Propriétaire Business',
                'email' => 'manager@sanar.sn',
                'password' => 'password',
                'role' => 'user', // Les managers sont des users qui possèdent des boutiques/restaurants
                'is_active' => true,
            ],
            [
                'name' => 'Graphiste Designer',
                'email' => 'designer@sanar.sn',
                'password' => 'password',
                'role' => 'designer',
                'is_active' => true,
            ],
            [
                'name' => 'Responsable Marketing',
                'email' => 'marketing@sanar.sn',
                'password' => 'password',
                'role' => 'marketing',
                'is_active' => true,
            ],
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
                'role' => $userData['role'],
                'is_active' => $userData['is_active'],
            ]);
        }
    }
}
