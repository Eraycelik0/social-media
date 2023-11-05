<?php

namespace App\Repositories\Like;

use App\Models\Like;
use App\Models\Post;

class LikeRepository implements LikeInterface
{

    public function create(array $data): Like
    {
        return Like::create($data);
    }

    public function delete(Like $like): bool
    {
        return $like->delete();
    }

    public function getById($id): ?Like
    {
        return Like::findOrFail($id);
    }

    public function getAll()
    {
        return Like::all();
    }
}
