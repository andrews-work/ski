<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use App\Events\PostCreated;

class ForumPostController extends Controller
{
    public function show(ForumPost $post)
    {
        $post->load('user', 'comments.user');

        Log::info('Viewing post with comments', [
            'post_id' => $post->id,
            'post_title' => $post->title,
            'comments' => $post->comments->map(function ($comment) {
                return [
                    'comment_id' => $comment->id,
                    'content' => $comment->content,
                    'user_id' => $comment->user_id,
                    'user_name' => $comment->user->name,
                ];
            }),
        ]);

        return Inertia::render('Auth/Forums', [
            'posts' => [],
            'post' => $post,
            'currentUser' => Auth::user(),
        ]);
    }

    public function store(Request $request)
    {
        Log::info('Creating a new post', $request->all());

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:forum_categories,id',
        ]);

        $post = ForumPost::create([
            'user_id' => Auth::user()->id,
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'category_id' => $validatedData['category_id'],
        ]);

        // Dispatch the PostCreated event
        event(new PostCreated($post));

        return redirect()->route('forums');
    }

    public function update(Request $request, ForumPost $post)
    {
        if (Gate::denies('update', $post)) {
            abort(403, 'You are not authorized to edit this post.');
        }

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'category' => 'sometimes|string',
        ]);

        $post->update($request->only(['title', 'content', 'category']));

        return redirect()->route('forums.show', $post);
    }

    public function destroy(ForumPost $post)
{
    Log::info('Attempting to delete post', ['post_id' => $post->id]);

    if (!Gate::allows('delete', $post)) {
        Log::warning('Unauthorized deletion attempt', ['user_id' => Auth::id(), 'post_id' => $post->id]);
        abort(403, 'You are not authorized to delete this post.');
    }

    Log::info('Deleting post', ['post_id' => $post->id]);
    $post->delete();

    Log::info('Post deleted successfully', ['post_id' => $post->id]);

    return redirect()->route('forums');

    Log::info('redirect');
}

}
