<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class ForumPostFactory extends Factory
{
    public function definition(): array
    {
        $createdAt = Carbon::now()->subDays(rand(0, 365));

        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
            'category' => $this->faker->randomElement(['General', 'Support', 'Off-Topic']),
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }
}
