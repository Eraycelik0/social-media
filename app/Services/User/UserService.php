<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserService
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        return $this->userRepository->getAll();
    }

    public function get($username)
    {
        $isUserExists = $this->userRepository->getBy($username);

        if (!$isUserExists) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        return $isUserExists;
    }

    public function delete($username): bool
    {
        $isUserExists = $this->userRepository->getBy($username);

        if (!$isUserExists) {
            return false;
        }

        $this->userRepository->delete($isUserExists);

        return true;
    }
}
