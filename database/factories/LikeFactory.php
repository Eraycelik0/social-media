<?php

namespace Database\Factories;

use App\Models\Like;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    protected $model = Like::class;

    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(["post", "comment", "story"]),
            'status' => $this->faker->randomDigitNotNull,
            'user_id' => \App\Models\User::factory(), // Rastgele bir kullanıcı id'si alır
            'post_id' => \App\Models\Post::factory(), // Rastgele bir post id'si alır
            'comment_id' => \App\Models\Comment::factory(), // Rastgele bir comment id'si alır
            'story_id' => null, // Eğer varsa bir story id'si
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }
}
