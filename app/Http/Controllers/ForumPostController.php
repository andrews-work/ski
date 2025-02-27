<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class ForumPostController extends Controller
{
    // Show single post
    public function show(ForumPost $post)
    {
        // Load the post with its user and comments
        $post->load('user', 'comments.user');

        // Log the post and its comments
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

    // Create a new post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
        ]);

        $post = ForumPost::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
        ]);

        return response()->json($post, 201);
    }

    // Update an existing post
    public function update(Request $request, ForumPost $post)
    {
        if (Gate::denies('update', $post)) {
            abort(403, 'You are not authorized to edit this post.');
        }

        // Validate the incoming data
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'category' => 'sometimes|string',
        ]);

        // Update the post with the new values
        $post->update($request->only(['title', 'content', 'category']));

        // Redirect back to the post's page after saving
        return redirect()->route('forums.show', $post);
    }

    // Delete a post
    public function destroy(ForumPost $post)
    {
        // Manually check authorization using the Gate facade
        if (!Gate::allows('delete', $post)) {
            abort(403, 'You are not authorized to delete this post.');
        }

        // If authorized, delete the post
        $post->delete();

        // Redirect back to the forums list page
        return redirect()->route('forums');
    }
}
