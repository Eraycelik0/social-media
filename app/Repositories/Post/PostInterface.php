<?php

namespace App\Repositories\Post;

use App\Models\Post;

interface PostInterface
{
    public function create(array $data): Post;
    public function update(Post $post, array $data): Post;
    public function delete(Post $post): bool;
    public function getById($id): ?Post;
    public function getAll();
}
