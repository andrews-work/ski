<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ForumCategoryController extends Controller
{
    // Show a specific category and its children
    public function show($id)
    {
        $category = ForumCategory::with('children')->findOrFail($id);

        // Return the category data to the Inertia page
        return Inertia::render('Auth/Forums', [
            'category' => $category,
            'posts' => (object) [], // Pass an empty object for posts

        ]);
    }
}
