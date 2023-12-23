<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CommentRepository implements CommentInterface
{
    public function check($id)
    {
        return Comment::with('user')->where('id', Crypt::decrypt($id))->where('user_id', auth()->user()->id)->first();
    }

    public function create(array $data): Comment
    {
        $comment = Comment::create($data);
        $comment = Comment::with('user')->where('id', $comment->id)->first();
        $comment->uuid = $comment->encrypted_id;
        return $comment;
    }

    public function update(Comment $comment, array $data): Comment
    {
        $comment->update($data);
        return $comment;
    }

    public function delete(Comment $comment): bool
    {
        return $comment->delete();
    }

    public function getAll()
    {
        return Comment::all();
    }

    public function getById($id): ?Comment
    {
        return Comment::find($id);
    }

    public function getCommentByUser()
    {
        $comments = Comment::with('user')->where('user_id', Auth::user()->id)->get();

        $comments->each(function ($comment) {
            $comment->uuid = $comment->encrypted_id;
        });

        return $comments;
    }

    public function getTotalCommentsCountByUserId($user_id)
    {
        return Comment::where('user_id', $user_id)->count();
    }

    public function getBy($id): ?Comment {
        $comment =  Comment::with('user')->where('id', Crypt::decrypt($id))->first();
        $comment->uuid = $comment->encrypted_id;
        return $comment;
    }
}
