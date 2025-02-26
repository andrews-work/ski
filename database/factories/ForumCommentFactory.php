<?php

namespace Database\Factories;

use App\Models\ForumComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ForumPost;

class ForumCommentFactory extends Factory
{
    protected $model = ForumComment::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'forum_post_id' => ForumPost::factory(),
            'content' => $this->faker->paragraph,
        ];
    }
}
