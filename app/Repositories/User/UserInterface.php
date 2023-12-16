<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserInterface
{
    public function create(array $data): User;
    public function update(User $user, array $data): User;
    public function delete(User $user): bool;
    public function getById($id): ?User;
    public function getAll();
}
