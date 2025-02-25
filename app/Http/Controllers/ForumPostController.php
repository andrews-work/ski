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
    // List all
    public function index(Request $request)
{
    // Log incoming request parameters
    Log::info('Fetching forum posts', [
        'request_params' => $request->all(),
    ]);

    $query = ForumPost::with('user');

    // Default sorting by date (descending)
    $sortDirection = $request->sort_direction === 'asc' ? 'asc' : 'desc';

    // Log the sort direction and the selected sorting criteria
    Log::info('Sorting posts', [
        'sort_by' => $request->sort_by ?? 'date',
        'sort_direction' => $sortDirection,
    ]);

    if ($request->filled('sort_by')) {
        switch ($request->sort_by) {
            case 'author':
                // Sort by author name, then by date
                $query->join('users', 'users.id', '=', 'forum_posts.user_id')
                    ->orderBy('users.name')
                    ->orderBy('forum_posts.created_at', $sortDirection);
                break;
            case 'category':
                // Sort by category, then by date
                $query->orderBy('category')
                    ->orderBy('created_at', $sortDirection);
                break;
            case 'date':
            default:
                // Sort by date
                $query->orderBy('created_at', $sortDirection);
                break;
        }
    } else {
        // Default sorting by date (descending)
        $query->orderBy('created_at', 'desc');
    }

    // Log the SQL query being executed (optional, for debugging)
    Log::info('SQL Query', [
        'sql' => $query->toSql(),
        'bindings' => $query->getBindings(),
    ]);

    // Paginate the results
    $posts = $query->paginate(5);

    // Log the number of posts retrieved
    Log::info('Posts fetched', [
        'total_posts' => $posts->total(),
        'current_page' => $posts->currentPage(),
        'per_page' => $posts->perPage(),
    ]);

    return Inertia::render('Auth/Forums', [
        'posts' => $posts,
        'currentUser' => Auth::user(),
        'filters' => $request->only(['sort_by', 'sort_direction']),
    ]);
}

    // Show single
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

    // Create
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

    // Update
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

    // Delete
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
