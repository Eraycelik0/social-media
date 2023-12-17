<?php

namespace App\Repositories\User;

use App\Models\User;
use DateTime;

class UserRepository implements UserInterface
{
    public function create(array $data): User
    {
        return User::create($data);
    }
    public function update(User $user, array $data): User
    {
        $data['date_of_birth'] = (new DateTime($data['date_of_birth']))->format('Y-m-d');
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
