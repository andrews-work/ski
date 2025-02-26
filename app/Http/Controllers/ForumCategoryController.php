<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ForumCategoryController extends Controller
{
    public function index()
    {
        $categories = ForumCategory::with('children.children.children')
            ->whereNull('parent_id')
            ->get();

        Log::info('Fetched categories:', $categories->toArray());
        
        return response()->json(['categories' => $categories]);

    }

    public function show($id)
    {
        $category = ForumCategory::with('children.children.children')->findOrFail($id);
        return response()->json(['category' => $category]);
    }
}
