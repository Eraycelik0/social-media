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
        if($data['date_of_birth'] !== null){
            $data['date_of_birth'] = (new DateTime($data['date_of_birth']))->format('Y-m-d');
        }

        $user->update($data);
        return $user;
    }
    public function delete(User $user): bool
    {
        return $user->delete();
    }
    public function getBy($username): ?User
    {
        return User::where('username', $username)->first();
    }
    public function getAll()
    {
        return User::get();
    }
}
