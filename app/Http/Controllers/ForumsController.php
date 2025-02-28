<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use App\Models\ForumPost;
use Illuminate\Support\Facades\Log;

class ForumsController extends Controller
{
    public function index(Request $request)
    {
        // Check if a new post has been created
        Log::info('Fetching latest post from cache.');

        $latestPost = Cache::get('latest_post');

        // Log if there's a post or if it's null
        if ($latestPost) {
            Log::info('Latest post found in cache: ', ['latestPost' => $latestPost->title]);
        } else {
            Log::info('No latest post found in cache.');
        }

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
            'latestPost' => $latestPost,
        ]);
    }
}
