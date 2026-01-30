<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\ForumThread;
use App\Models\ForumReply;
use App\Models\ForumGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $user = User::where('email', 'user@sanar.sn')->first();
        $premium = User::where('email', 'premium@sanar.sn')->first();

        // --- ANNOUNCEMENTS ---
        $categories = Category::all();

        foreach ($categories as $category) {
            $subcategory = SubCategory::where('category_id', $category->id)->first();

            Announcement::create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'subcategory_id' => $subcategory->id,
                'title' => "Démonstration: " . $category->name,
                'description' => "Ceci est une annonce de démonstration pour la catégorie " . $category->name . ". Elle montre comment les annonces sont affichées dans SanarWeb.",
                'price' => rand(5000, 500000),
                'location' => 'Saint-Louis, Sénégal',
                'status' => 'active',
                'validation_status' => 'approved',
                'validated_by' => $admin->id,
                'validated_at' => now(),
                'featured' => rand(0, 1),
            ]);
        }

        // --- FORUM ---
        $group = ForumGroup::create([
            'name' => 'Général',
            'slug' => 'general',
            'description' => 'Discussions générales sur la vie au campus.',
            'is_private' => false,
        ]);

        $thread = ForumThread::create([
            'group_id' => $group->id,
            'user_id' => $user->id,
            'title' => 'Bienvenue sur le nouveau forum SanarWeb !',
            'slug' => 'bienvenue-sur-le-nouveau-forum-sanarweb',
            'body' => 'N\'hésitez pas à poser vos questions et à partager vos bons plans ici.',
        ]);

        ForumReply::create([
            'user_id' => $admin->id,
            'thread_id' => $thread->id,
            'body' => 'Merci ! Nous sommes ravis de lancer cette nouvelle plateforme.',
        ]);
    }
}
