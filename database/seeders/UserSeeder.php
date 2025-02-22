<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory () -> create ([
            'name' => 'Test',
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
        ]);

        User::factory () -> create ([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);

        User::factory () -> create ([
            'name' => 'emp',
            'email' => 'emp@emp.com',
            'password' => Hash::make('password'),
        ]);

        User::factory () -> create ([
            'name' => 'client',
            'email' => 'client@client.com',
            'password' => Hash::make('password'),
        ]);

        User::factory () -> create ([
            'name' => 'client1',
            'email' => 'client1@client1.com',
            'password' => Hash::make('password'),
        ]);

        User::factory () -> create ([
            'name' => 'client2',
            'email' => 'client2@client2.com',
            'password' => Hash::make('password'),
        ]);

        User::factory () -> create ([
            'name' => 'client3',
            'email' => 'client3@client3.com',
            'password' => Hash::make('password'),
        ]);
    }
}
