<?php

namespace Database\Factories;

use App\Models\Follower;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Follower>
 */
class FollowerFactory extends Factory
{
    protected $model = Follower::class;

    public function definition()
    {
        return [
            'status' => $this->faker->numberBetween(0, 1),
            'from' => \App\Models\User::factory(), // Takip isteği gönderen kullanıcı ID'si
            'to' => \App\Models\User::factory(), // Takip edilen kullanıcı ID'si
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }
}
