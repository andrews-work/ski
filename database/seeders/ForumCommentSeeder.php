<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ForumPost;
use App\Models\ForumComment;
use Illuminate\Database\Seeder;

class ForumCommentSeeder extends Seeder
{
    public function run()
    {
        // Get all users and posts
        $users = User::all();
        $posts = ForumPost::all();

        // Ensure each user has at least 2 comments
        foreach ($users as $user) {
            ForumComment::factory()->count(2)->create([
                'user_id' => $user->id,
                'forum_post_id' => $posts->random()->id, // Use 'forum_post_id' instead of 'post_id'
            ]);
        }

        // Ensure each post has at least 2 comments
        foreach ($posts as $post) {
            ForumComment::factory()->count(2)->create([
                'user_id' => $users->random()->id,
                'forum_post_id' => $post->id, // Use 'forum_post_id' instead of 'post_id'
            ]);
        }
    }
}
