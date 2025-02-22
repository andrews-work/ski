<?php

namespace App\Policies;

use App\Models\ForumPost;
use App\Models\User;

class ForumPostPolicy
{
    /**
     * Determine if the given post can be deleted by the user.
     */
    public function delete(User $user, ForumPost $post): bool
    {
        // Only the post owner can delete the post
        return $user->id === $post->user_id;
    }

    public function update(User $user, ForumPost $post): bool
    {
        return $user->id === $post->user_id;
    }

}
