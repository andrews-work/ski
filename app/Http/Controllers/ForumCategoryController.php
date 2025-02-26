<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use Illuminate\Http\Request;

class ForumCategoryController extends Controller
{
    public function index()
    {
        $categories = ForumCategory::with('children.children.children')
            ->whereNull('parent_id')
            ->get();

        return response()->json(['categories' => $categories]);
    }

    public function show($id)
    {
        $category = ForumCategory::with('children.children.children')->findOrFail($id);
        return response()->json(['category' => $category]);
    }
}
