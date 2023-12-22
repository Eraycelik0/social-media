<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserInterface
{
    public function create(array $data): User;
    public function update(User $user, array $data): User;
    public function delete(User $user): bool;
    public function getBy($username): ?User;
    public function getAll();
}
