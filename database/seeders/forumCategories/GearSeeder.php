<?php

namespace Database\Seeders\forumCategories;

use App\Models\ForumCategory;
use Illuminate\Database\Seeder;

class GearSeeder extends Seeder
{
    public function run()
    {
        $gear = ForumCategory::create([
            'name' => 'Gear',
            'description' => 'Discuss ski and snowboard gear, brands, and equipment.',
        ]);

        // Skis Categories
        $skis = ForumCategory::create([
            'name' => 'Skis',
            'parent_id' => $gear->id,
        ]);

        ForumCategory::create([
            'name' => 'Race',
            'parent_id' => $skis->id,
        ]);

        ForumCategory::create([
            'name' => 'All Mountain',
            'parent_id' => $skis->id,
        ]);

        ForumCategory::create([
            'name' => 'Park',
            'parent_id' => $skis->id,
        ]);

        ForumCategory::create([
            'name' => 'Free Ride',
            'parent_id' => $skis->id,
        ]);

        ForumCategory::create([
            'name' => 'Backcountry',
            'parent_id' => $skis->id,
        ]);

        ForumCategory::create([
            'name' => 'X-Country',
            'parent_id' => $skis->id,
        ]);

        ForumCategory::create([
            'name' => 'Big Mountain',
            'parent_id' => $skis->id,
        ]);

        ForumCategory::create([
            'name' => 'Powder',
            'parent_id' => $skis->id,
        ]);

        // Snowboards Categories
        $snowboards = ForumCategory::create([
            'name' => 'Snowboards',
            'parent_id' => $gear->id,
        ]);

        ForumCategory::create([
            'name' => 'Split Boards',
            'parent_id' => $snowboards->id,
        ]);

        ForumCategory::create([
            'name' => 'Powder',
            'parent_id' => $snowboards->id,
        ]);

        ForumCategory::create([
            'name' => 'Park',
            'parent_id' => $snowboards->id,
        ]);

        // Gloves Categories
        $gloves = ForumCategory::create([
            'name' => 'Gloves',
            'parent_id' => $gear->id,
        ]);

        ForumCategory::create([
            'name' => 'Inners',
            'parent_id' => $gloves->id,
        ]);

        ForumCategory::create([
            'name' => 'Outers',
            'parent_id' => $gloves->id,
        ]);

        // Clothes Categories
        $clothes = ForumCategory::create([
            'name' => 'Clothes',
            'parent_id' => $gear->id,
        ]);

        ForumCategory::create([
            'name' => 'Socks',
            'parent_id' => $clothes->id,
        ]);

        ForumCategory::create([
            'name' => 'Jackets',
            'parent_id' => $clothes->id,
        ]);

        ForumCategory::create([
            'name' => 'Pants',
            'parent_id' => $clothes->id,
        ]);

        ForumCategory::create([
            'name' => 'Thermals',
            'parent_id' => $clothes->id,
        ]);

        ForumCategory::create([
            'name' => 'Hoodies',
            'parent_id' => $clothes->id,
        ]);

        // Boots Categories
        $boots = ForumCategory::create([
            'name' => 'Boots',
            'parent_id' => $gear->id,
        ]);

        ForumCategory::create([
            'name' => 'Après',
            'parent_id' => $boots->id,
        ]);

        ForumCategory::create([
            'name' => 'Ski',
            'parent_id' => $boots->id,
        ]);

        ForumCategory::create([
            'name' => 'Snowboard',
            'parent_id' => $boots->id,
        ]);

        // Additional Categories
        ForumCategory::create([
            'name' => 'Bindings',
            'parent_id' => $gear->id,
        ]);

        ForumCategory::create([
            'name' => 'Brands',
            'parent_id' => $gear->id,
        ]);

        ForumCategory::create([
            'name' => 'Poles',
            'parent_id' => $gear->id,
        ]);

        ForumCategory::create([
            'name' => 'Goggles',
            'parent_id' => $gear->id,
        ]);
    }
}
