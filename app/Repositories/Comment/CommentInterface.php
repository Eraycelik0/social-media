<?php

namespace App\Repositories\Comment;

use App\Models\Comment;

interface CommentInterface
{
public function create(array $data): Comment;
public function update(Comment $comment): Comment;
public function delete(Comment $comment): bool;
public function getById($id): ?Comment;
public function getAll();
}
