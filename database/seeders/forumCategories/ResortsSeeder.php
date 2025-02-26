<?php

namespace Database\Seeders\forumCategories;

use App\Models\ForumCategory;
use Illuminate\Database\Seeder;
use Database\Seeders\forumCategories\continents\NorthAmericaSeeder;
use Database\Seeders\forumCategories\continents\EuropeSeeder;
use Database\Seeders\forumCategories\continents\AustraliaNewZealandSeeder;

class ResortsSeeder extends Seeder
{
    public function run()
    {
        // Create the main Resorts category
        $resorts = ForumCategory::create([
            'name' => 'Resorts',
            'description' => 'Find and discuss ski resorts around the world.',
        ]);

        // Run the continent seeders
        $this->call(NorthAmericaSeeder::class);
        $this->call(EuropeSeeder::class);
        $this->call(AustraliaNewZealandSeeder::class);
    }
}
