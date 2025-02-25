<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ForumCategoryController extends Controller
{
    public function index()
{
    Log::info('categories function');

    $categories = ForumCategory::all();

    Log::info('categories fetched', ['categories' => $categories]);

    // Return categories as JSON
    return response()->json([
        'categories' => $categories
    ]);
}

}
