<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Follower;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void {
        User::factory()->count(10)->create();
        Post::factory()->count(50)->create();
        Comment::factory()->count(100)->create();
        Like::factory()->count(100)->create();
        Follower::factory()->count(100)->create();
    }
}
