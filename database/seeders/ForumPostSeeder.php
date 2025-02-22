<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ForumPost;
use Illuminate\Database\Seeder;

class ForumPostSeeder extends Seeder
{
    public function run(): void
    {
        // Get all users
        $users = User::all();

        // For each user, create 2 posts
        $users->each(function ($user) {
            ForumPost::factory()->count(2)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}

