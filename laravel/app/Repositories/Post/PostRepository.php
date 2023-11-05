<?php

namespace App\Repositories\Post;

use App\Models\Post;

class PostRepository implements PostInterface
{

    public function create(array $data): Post
    {
       return Post::create($data);
    }

    public function update(Post $post, array $data): Post
    {
       $post->update($data);
       return $post;
    }

    public function delete(Post $post): bool
    {
        return $post->delete();
    }

    public function getById($id): ?Post
    {
        return Post::find($id);
    }

    public function getAll()
    {
        return Post::get();
    }
}
