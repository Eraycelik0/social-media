<?php

namespace App\Repositories\Like;

use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeRepository implements LikeInterface
{
    public function create(array $data): Like {
        return Like::create($data);
    }
    public function delete(Like $like): bool
    {
        return $like->delete();
    }
    public function getById($id): ?Like
    {
        return Like::where('id', $id)->where('user_id', Auth::user()->id)->first();
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
