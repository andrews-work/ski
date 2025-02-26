<?php

namespace Database\Seeders;

use App\Models\ForumCategory;
use Illuminate\Database\Seeder;

class SafetySeeder extends Seeder
{
    public function run()
    {
        $safety = ForumCategory::create([
            'name' => 'Safety',
            'description' => 'Learn and discuss safety rules and best practices.',
        ]);

        ForumCategory::create([
            'name' => 'Rules',
            'parent_id' => $safety->id,
        ]);

        ForumCategory::create([
            'name' => 'Avalanche Safety',
            'parent_id' => $safety->id,
        ]);

        ForumCategory::create([
            'name' => 'First Aid',
            'parent_id' => $safety->id,
        ]);
    }
}
