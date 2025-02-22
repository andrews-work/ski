<?php

namespace Database\Seeders;

use App\Models\Meeting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MeetingSeeder extends Seeder
{
    public function run()
    {
        // Fetch all users
        $users = User::all();

        // Check if there are at least 2 users
        if ($users->count() < 2) {
            $this->command->info('Please create at least 2 users to seed meetings.');
            return;
        }

        // Seed Meetings
        $meetingsData = [
            [
                'title' => 'Team Sync',
                'description' => 'Weekly team meeting to discuss progress and blockers.',
                'date' => Carbon::create('2025', '02', '15')->format('Y-m-d'),
                'time' => '10:00:00',
                'location' => 'Conference Room A',
                'user_id' => $users->random()->id,  // Random user
            ],
            [
                'title' => 'Product Launch Prep',
                'description' => 'Prepare for the upcoming product launch.',
                'date' => Carbon::create('2025', '03', '01')->format('Y-m-d'),
                'time' => '14:00:00',
                'location' => 'Boardroom',
                'user_id' => $users->random()->id,  // Random user
            ],
            [
                'title' => 'Quarterly Review',
                'description' => 'Review the progress for the last quarter.',
                'date' => Carbon::create('2025', '03', '15')->format('Y-m-d'),
                'time' => '09:00:00',
                'location' => 'Main Conference Room',
                'user_id' => $users->random()->id,  // Random user
            ],
            [
                'title' => 'Team Retrospective',
                'description' => 'Reflect on the past sprint and identify improvements.',
                'date' => Carbon::create('2025', '04', '05')->format('Y-m-d'),
                'time' => '16:00:00',
                'location' => 'Remote (Zoom)',
                'user_id' => $users->random()->id,  // Random user
            ],
        ];

        // Create meetings
        foreach ($meetingsData as $meetingData) {
            Meeting::create($meetingData);
        }
    }
}
