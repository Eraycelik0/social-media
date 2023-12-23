<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{

    protected $model = Post::class;

    public function definition()
    {
        return [
            'post_text' => $this->faker->paragraph,
            'media_share' => json_encode([$this->faker->imageUrl(), $this->faker->imageUrl()]),
            'user_id' => \App\Models\User::factory(), // Rastgele bir kullanıcı id'si alır
            'pinned_post_id' => null, // Varsa rastgele bir başka postun id'si
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }
}
