<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\ForumCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class ForumsController extends Controller
{
    // List all posts and categories
    public function index(Request $request)
    {
        // Fetch posts
        $query = ForumPost::with('user');
        $sortDirection = $request->sort_direction === 'asc' ? 'asc' : 'desc';

        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 'author':
                    $query->join('users', 'users.id', '=', 'forum_posts.user_id')
                        ->orderBy('users.name')
                        ->orderBy('forum_posts.created_at', $sortDirection);
                    break;
                case 'category':
                    $query->orderBy('category')
                        ->orderBy('created_at', $sortDirection);
                    break;
                case 'date':
                default:
                    $query->orderBy('created_at', $sortDirection);
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $posts = $query->paginate(5);

        // Fetch categories
        $categories = ForumCategory::with('children.children.children')
            ->whereNull('parent_id')
            ->get();

        return Inertia::render('Auth/Forums', [
            'posts' => $posts,
            'categories' => $categories,
            'currentUser' => Auth::user(),
            'filters' => $request->only(['sort_by', 'sort_direction']),
        ]);
    }

    // Show single post
    // public function show(ForumPost $post)
    // {
    //     $post->load('user', 'comments.user');

    //     return Inertia::render('Auth/Forums', [
    //         'posts' => [],
    //         'post' => $post,
    //         'currentUser' => Auth::user(),
    //     ]);
    // }
}
