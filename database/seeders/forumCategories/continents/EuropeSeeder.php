<?php

namespace Database\Seeders\forumCategories\continents;

use App\Models\ForumCategory;
use Illuminate\Database\Seeder;

class EuropeSeeder extends Seeder
{
    public function run()
    {
        $europe = ForumCategory::create([
            'name' => 'Europe',
            'description' => 'Ski resorts in Europe.',
            'parent_id' => '1',
        ]);

        $france = ForumCategory::create([
            'name' => 'France',
            'parent_id' => $europe->id,
        ]);

        ForumCategory::create([
            'name' => 'Chamonix',
            'parent_id' => $france->id,
        ]);

        ForumCategory::create([
            'name' => 'Les Arcs',
            'parent_id' => $france->id,
        ]);

        $italy = ForumCategory::create([
            'name' => 'Italy',
            'parent_id' => $europe->id,
        ]);

        ForumCategory::create([
            'name' => 'Cortina d\'Ampezzo',
            'parent_id' => $italy->id,
        ]);

        ForumCategory::create([
            'name' => 'Val Gardena',
            'parent_id' => $italy->id,
        ]);
    }
}
