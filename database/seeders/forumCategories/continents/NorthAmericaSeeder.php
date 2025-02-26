<?php

namespace Database\Seeders\forumCategories\continents;

use App\Models\ForumCategory;
use Illuminate\Database\Seeder;

class NorthAmericaSeeder extends Seeder
{
    public function run()
    {
        $northAmerica = ForumCategory::create([
            'name' => 'North America',
            'description' => 'Ski resorts in North America.',
            'parent_id' => '1',
        ]);

        $usa = ForumCategory::create([
            'name' => 'USA',
            'parent_id' => $northAmerica->id,
        ]);

        ForumCategory::create([
            'name' => 'Aspen',
            'parent_id' => $usa->id,
        ]);

        ForumCategory::create([
            'name' => 'Park City',
            'parent_id' => $usa->id,
        ]);

        $canada = ForumCategory::create([
            'name' => 'Canada',
            'parent_id' => $northAmerica->id,
        ]);

        ForumCategory::create([
            'name' => 'Whistler',
            'parent_id' => $canada->id,
        ]);

        ForumCategory::create([
            'name' => 'Banff',
            'parent_id' => $canada->id,
        ]);
    }
}
