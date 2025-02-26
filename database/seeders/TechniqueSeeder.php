<?php

namespace Database\Seeders;

use App\Models\ForumCategory;
use Illuminate\Database\Seeder;

class TechniqueSeeder extends Seeder
{
    public function run()
    {
        $technique = ForumCategory::create([
            'name' => 'Technique',
            'description' => 'Learn and improve your skiing techniques.',
        ]);

        ForumCategory::create([
            'name' => 'Groomers',
            'parent_id' => $technique->id,
        ]);

        ForumCategory::create([
            'name' => 'Park',
            'parent_id' => $technique->id,
        ]);

        ForumCategory::create([
            'name' => 'Trees',
            'parent_id' => $technique->id,
        ]);

        ForumCategory::create([
            'name' => 'Powder',
            'parent_id' => $technique->id,
        ]);

        ForumCategory::create([
            'name' => 'Cliffs',
            'parent_id' => $technique->id,
        ]);

        ForumCategory::create([
            'name' => 'Backcountry',
            'parent_id' => $technique->id,
        ]);

        ForumCategory::create([
            'name' => 'Crosscountry',
            'parent_id' => $technique->id,
        ]);
    }
}
