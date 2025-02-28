<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ForumCategoryController extends Controller
{
    public function show($name)
    {
        // Fetch the category by its name and load all nested children
        $category = ForumCategory::where('name', $name)
            ->with('children.children.children') // Load nested relationships
            ->firstOrFail();

        // Fetch posts related to the category
        $posts = ForumPost::where('category_id', $category->id)
            ->with('user')
            ->paginate(5);

        return Inertia::render('Auth/Forums', [
            'category' => $category,
            'posts' => $posts,
            'currentUser' => Auth::user(),
        ]);
    }

    public function continent($name, $continent)
{
    // Fetch the parent category by its name
    $parentCategory = ForumCategory::where('name', $name)->firstOrFail();

    // Fetch the continent (subcategory) by its name and parent_id
    $continent = ForumCategory::where('name', $continent)
        ->where('parent_id', $parentCategory->id)
        ->with('children.children') // Load nested children (countries and resorts)
        ->firstOrFail();

    return Inertia::render('Auth/Forums', [
        'category' => $continent, // Pass the continent as the main category
        'currentUser' => Auth::user(),
    ]);
}

    public function countries($name, $continent, $country)
    {
        // Fetch the parent category by its name
        $parentCategory = ForumCategory::where('name', $name)->firstOrFail();

        // Fetch the continent (subcategory) by its name and parent_id
        $continent = ForumCategory::where('name', $continent)
            ->where('parent_id', $parentCategory->id)
            ->firstOrFail();

        // Fetch the country by its name and parent_id
        $country = ForumCategory::where('name', $country)
            ->where('parent_id', $continent->id)
            ->with('children') // Load nested children (resorts)
            ->firstOrFail();

        return Inertia::render('Auth/Forums', [
            'category' => $country, // Pass the country as the main category
            'currentUser' => Auth::user(),
        ]);
    }

    public function resort($name, $continent, $country, $resort)
    {
        // Fetch the parent category by its name
        $parentCategory = ForumCategory::where('name', $name)->firstOrFail();

        // Fetch the continent (subcategory) by its name and parent_id
        $continent = ForumCategory::where('name', $continent)
            ->where('parent_id', $parentCategory->id)
            ->firstOrFail();

        // Fetch the country by its name and parent_id
        $country = ForumCategory::where('name', $country)
            ->where('parent_id', $continent->id)
            ->firstOrFail();

        // Fetch the resort by its name and parent_id
        $resort = ForumCategory::where('name', $resort)
            ->where('parent_id', $country->id)
            ->firstOrFail();

        return Inertia::render('Auth/Forums', [
            'category' => $resort, // Pass the resort as the main category
            'currentUser' => Auth::user(),
        ]);
    }
}
