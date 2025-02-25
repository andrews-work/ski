<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ForumPost;
use App\Models\ForumCategory;
use Illuminate\Database\Seeder;

class ForumPostSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $categories = ForumCategory::all(); 

        // For each user, create 2 posts
        $users->each(function ($user) use ($categories) {
            ForumPost::factory()->count(2)->create([
                'user_id' => $user->id,
                'category_id' => $categories->random()->id,
            ]);
        });
    }
}
