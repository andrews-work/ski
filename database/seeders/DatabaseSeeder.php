<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\MeetingSeeder;
use Database\Seeders\ForumPostSeeder;
use Database\Seeders\ForumCommentSeeder;
use Database\Seeders\ForumCategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this -> call(UserSeeder::class);
        $this -> call(MeetingSeeder::class);
        $this -> call(ForumCategorySeeder::class);
        $this -> call(ForumPostSeeder::class);
        $this -> call(ForumCommentSeeder::class);
    }
}
