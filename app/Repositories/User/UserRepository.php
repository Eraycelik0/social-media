<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository implements UserInterface
{
    public function create(array $data): User
    {
        return User::create($data);
    }
    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }
    public function delete(User $user): bool
    {
        return $user->delete();
    }
    public function getById($id): ?User
    {
        return User::find($id);
    }
    public function getAll()
    {
        return User::get();
    }
}
