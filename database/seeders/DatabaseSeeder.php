<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\MeetingSeeder;
use Database\Seeders\ForumPostSeeder;
use Database\Seeders\ForumCommentSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this -> call(UserSeeder::class);
        $this -> call(MeetingSeeder::class);
        $this -> call(ForumPostSeeder::class);
        $this -> call(ForumCommentSeeder::class);
    }
}
