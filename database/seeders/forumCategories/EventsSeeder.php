<?php

namespace Database\Seeders\forumCategories;

use App\Models\ForumCategory;
use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    public function run()
    {
        $events = ForumCategory::create([
            'name' => 'Events',
            'description' => 'Discuss skiing events, competitions, and tours.',
        ]);

        ForumCategory::create([
            'name' => 'Free Ride World Tour',
            'parent_id' => $events->id,
        ]);

        ForumCategory::create([
            'name' => 'Alpine',
            'parent_id' => $events->id,
        ]);

        ForumCategory::create([
            'name' => 'Park',
            'parent_id' => $events->id,
        ]);

        ForumCategory::create([
            'name' => 'X-country',
            'parent_id' => $events->id,
        ]);

        ForumCategory::create([
            'name' => 'Local Events',
            'parent_id' => $events->id,
        ]);
    }
}
