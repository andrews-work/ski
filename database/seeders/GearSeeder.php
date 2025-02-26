<?php

namespace Database\Seeders;

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

        ForumCategory::create([
            'name' => 'Skis',
            'parent_id' => $gear->id,
        ]);

        ForumCategory::create([
            'name' => 'Snowboards',
            'parent_id' => $gear->id,
        ]);

        ForumCategory::create([
            'name' => 'Boots',
            'parent_id' => $gear->id,
        ]);

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
            'name' => 'Gloves',
            'parent_id' => $gear->id,
        ]);

        ForumCategory::create([
            'name' => 'Goggles',
            'parent_id' => $gear->id,
        ]);
    }
}
