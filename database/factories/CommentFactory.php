<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{

    protected $model = Comment::class;

    public function definition()
    {
        return [
            'comment_text' => $this->faker->paragraph,
            'user_id' => \App\Models\User::factory(), // Rastgele bir kullanıcı id'si alır
            'post_id' => \App\Models\Post::factory(), // Rastgele bir post id'si alır
            'parent_id' => null, // Eğer varsa bir üst yorumun id'si
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }
}
