<?php

namespace Database\Seeders;

use App\Models\ForumCategory;
use Illuminate\Database\Seeder;

class ResortsSeeder extends Seeder
{
    public function run()
    {
        $resorts = ForumCategory::create([
            'name' => 'Resorts',
            'description' => 'Find and discuss ski resorts around the world.',
        ]);

        $northAmerica = ForumCategory::create([
            'name' => 'North America',
            'parent_id' => $resorts->id,
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

        $europe = ForumCategory::create([
            'name' => 'Europe',
            'parent_id' => $resorts->id,
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

        $australiaNZ = ForumCategory::create([
            'name' => 'Australia/New Zealand',
            'parent_id' => $resorts->id,
        ]);

        $australia = ForumCategory::create([
            'name' => 'Australia',
            'parent_id' => $australiaNZ->id,
        ]);

        ForumCategory::create([
            'name' => 'Perisher',
            'parent_id' => $australia->id,
        ]);

        ForumCategory::create([
            'name' => 'Mt Buller',
            'parent_id' => $australia->id,
        ]);

        ForumCategory::create([
            'name' => 'Mt Hotham',
            'parent_id' => $australia->id,
        ]);

        $newZealand = ForumCategory::create([
            'name' => 'New Zealand',
            'parent_id' => $australiaNZ->id,
        ]);

        ForumCategory::create([
            'name' => 'Remarkables',
            'parent_id' => $newZealand->id,
        ]);
    }
}
