<?php

namespace App\Repositories\Like;

use App\Models\Like;

interface LikeInterface
{
    public function create(array $data): Like;
    public function update(Like $post, array $data): Like;
    public function delete(Like $post): bool;
    public function getById($id): ?Like;
    public function getAll();
}
