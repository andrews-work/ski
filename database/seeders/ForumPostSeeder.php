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

        $topLevelCategories = ForumCategory::whereNull('parent_id')->get();

        // 2 posts per user
        $users->each(function ($user) use ($topLevelCategories) {
            ForumPost::factory()->count(2)->create([
                'user_id' => $user->id,
                'category_id' => $topLevelCategories->random()->id,
            ]);
        });
    }
}
