<?php

namespace App\Http\Controllers;

use App\Models\ForumComment;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use App\Mail\UserCommentedOnPost;
use Illuminate\Support\Facades\Mail;

class ForumCommentController extends Controller
{
    // Store a new comment
    public function store(Request $request, ForumPost $post)
{
    $request->validate([
        'content' => 'required|string|max:1000',
    ]);

    $comment = $post->comments()->create([
        'user_id' => Auth::id(),
        'content' => $request->content,
    ]);

    // Log the creation of a new comment
    Log::info('New comment created', [
        'comment_id' => $comment->id,
        'post_id' => $post->id,
        'user_id' => Auth::id(),
    ]);

    // Send email to the post author
    try {
        Mail::to($post->user->email)->send(new UserCommentedOnPost($post, $comment));

        // Log that the email was sent successfully
        Log::info('Email sent successfully', [
            'post_id' => $post->id,
            'comment_id' => $comment->id,
            'recipient_email' => $post->user->email,
        ]);
    } catch (\Exception $e) {
        // Log any errors that occur while sending the email
        Log::error('Failed to send email', [
            'post_id' => $post->id,
            'comment_id' => $comment->id,
            'error' => $e->getMessage(),
        ]);
    }

    // Redirect back to the post's page
    return redirect()->route('forums.show', $post);
}

    // Update a comment
    public function update(Request $request, ForumComment $comment)
    {
        if (Gate::denies('update', $comment)) {
            abort(403, 'You are not authorized to edit this comment.');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update($request->only('content'));

        // Log the update of a comment
        Log::info('Comment updated', [
            'comment_id' => $comment->id,
            'post_id' => $comment->post->id,
            'user_id' => Auth::id(),
        ]);

        // Redirect back to the post's page
        return redirect()->route('forums.show', $comment->post);
    }

    // Delete a comment
    public function destroy(ForumComment $comment)
    {
        if (Gate::denies('delete', $comment)) {
            abort(403, 'You are not authorized to delete this comment.');
        }

        // Log the deletion of a comment
        Log::info('Comment deleted', [
            'comment_id' => $comment->id,
            'post_id' => $comment->post->id,
            'user_id' => Auth::id(),
        ]);

        $comment->delete();

        // Redirect back to the post's page
        return redirect()->route('forums.show', $comment->post);
    }

    // create mailable comment
    public function userCommentPost()
    {
        // write logic to send an email to the user who created the post
        return redirect()->mail()->mailable;
    }
}
