<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\forumCategories\ResortsSeeder;
use Database\Seeders\forumCategories\GearSeeder;
use Database\Seeders\forumCategories\EventsSeeder;
use Database\Seeders\forumCategories\TechniqueSeeder;
use Database\Seeders\forumCategories\SafetySeeder;

class ForumCategorySeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ResortsSeeder::class,
            GearSeeder::class,
            EventsSeeder::class,
            TechniqueSeeder::class,
            SafetySeeder::class,
        ]);
    }
}


