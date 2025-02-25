<?php

namespace Database\Seeders;

use App\Models\ForumCategory;
use Illuminate\Database\Seeder;

class ForumCategorySeeder extends Seeder
{
    public function run()
    {
        ForumCategory::create([
            'name' => 'Resorts',
            'description' => 'Find and discuss ski resorts around the world.',
        ]);

        ForumCategory::create([
            'name' => 'Gear',
            'description' => 'Discuss ski and snowboard gear, brands, and equipment.',
        ]);

        ForumCategory::create([
            'name' => 'Events',
            'description' => 'Discuss skiing events, competitions, and tours.',
        ]);

        ForumCategory::create([
            'name' => 'Safety',
            'description' => 'Learn and discuss safety rules and best practices.',
        ]);

        ForumCategory::create([
            'name' => 'Technique',
            'description' => 'Learn and improve your skiing techniques.',
        ]);
    }
}
