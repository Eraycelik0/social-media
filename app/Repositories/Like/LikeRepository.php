<?php

namespace App\Repositories\Like;

use App\Models\Like;

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
        return Like::find($id);
    }
    public function getAll()
    {
        return Like::all();
    }
    public function update(Like $like, array $data): Like
    {
        $like->update($data);
        return $like;
    }
}
