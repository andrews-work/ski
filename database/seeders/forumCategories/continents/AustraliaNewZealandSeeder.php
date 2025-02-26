<?php

namespace Database\Seeders\forumCategories\continents;

use App\Models\ForumCategory;
use Illuminate\Database\Seeder;

class AustraliaNewZealandSeeder extends Seeder
{
    public function run()
    {
        $australiaNZ = ForumCategory::create([
            'name' => 'Australia/New Zealand',
            'description' => 'Ski resorts in Australia and New Zealand.',
            'parent_id' => '1',
        ]);

        // Australia
        $australia = ForumCategory::create([
            'name' => 'Australia',
            'parent_id' => $australiaNZ->id,
        ]);

                // Australian resorts
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

                ForumCategory::create([
                    'name' => 'Falls Creek',
                    'parent_id' => $australia->id,
                ]);

                ForumCategory::create([
                    'name' => 'Thredbo',
                    'parent_id' => $australia->id,
                ]);

                ForumCategory::create([
                    'name' => 'Dinner Plain',
                    'parent_id' => $australia->id,
                ]);

                ForumCategory::create([
                    'name' => 'Charlotte Pass',
                    'parent_id' => $australia->id,
                ]);

                ForumCategory::create([
                    'name' => 'Lake Mountain',
                    'parent_id' => $australia->id,
                ]);

                ForumCategory::create([
                    'name' => 'Selwyn Snow Resort',
                    'parent_id' => $australia->id,
                ]);

                ForumCategory::create([
                    'name' => 'Baw Baw',
                    'parent_id' => $australia->id,
                ]);

        // New Zealand
        $newZealand = ForumCategory::create([
            'name' => 'New Zealand',
            'parent_id' => $australiaNZ->id,
        ]);

                // New Zealand resorts
                ForumCategory::create([
                    'name' => 'Remarkables',
                    'parent_id' => $newZealand->id,
                ]);

                ForumCategory::create([
                    'name' => 'Coronet Peak',
                    'parent_id' => $newZealand->id,
                ]);

                ForumCategory::create([
                    'name' => 'Cardrona',
                    'parent_id' => $newZealand->id,
                ]);

                ForumCategory::create([
                    'name' => 'Treble Cone',
                    'parent_id' => $newZealand->id,
                ]);

                ForumCategory::create([
                    'name' => 'Turoa',
                    'parent_id' => $newZealand->id,
                ]);

                ForumCategory::create([
                    'name' => 'Whakapapa',
                    'parent_id' => $newZealand->id,
                ]);

                ForumCategory::create([
                    'name' => 'Mt Ruapehu',
                    'parent_id' => $newZealand->id,
                ]);

                ForumCategory::create([
                    'name' => 'Broken River',
                    'parent_id' => $newZealand->id,
                ]);

                ForumCategory::create([
                    'name' => 'Craigieburn Valley',
                    'parent_id' => $newZealand->id,
                ]);

                ForumCategory::create([
                    'name' => 'Mount Olympus',
                    'parent_id' => $newZealand->id,
                ]);

                ForumCategory::create([
                    'name' => 'The Snow Farm',
                    'parent_id' => $newZealand->id,
                ]);

                ForumCategory::create([
                    'name' => 'Porters',
                    'parent_id' => $newZealand->id,
                ]);

                ForumCategory::create([
                    'name' => 'Cardrona Alpine Resort',
                    'parent_id' => $newZealand->id,
                ]);

                ForumCategory::create([
                    'name' => 'Mt Cheeseman',
                    'parent_id' => $newZealand->id,
                ]);

                ForumCategory::create([
                    'name' => 'The Remarkables Ski Area',
                    'parent_id' => $newZealand->id,
                ]);

                ForumCategory::create([
                    'name' => 'Rainbow Ski Area',
                    'parent_id' => $newZealand->id,
                ]);
    }
}
