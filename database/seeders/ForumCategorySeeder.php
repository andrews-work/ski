<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ResortsSeeder;
use Database\Seeders\GearSeeder;
use Database\Seeders\EventsSeeder;
use Database\Seeders\TechniqueSeeder;
use Database\Seeders\SafetySeeder;

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


