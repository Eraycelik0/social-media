<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentRepository implements CommentInterface {

    public function create(array $data): Comment
    {
        return Comment::create($data);
    }

    public function update(Comment $comment): Comment
    {
        $comment->save();
        return $comment;
    }

    public function delete(Comment $comment): bool
    {
        return $comment->delete();
    }

    public function getById($id): ?Comment
    {
        return Comment::find($id);
    }

    public function getAll()
    {
        return Comment::all();
    }
}
