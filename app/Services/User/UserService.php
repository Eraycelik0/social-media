<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;

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

    public function get($request)
    {
        return $this->userRepository->getById($request->id);
    }

    public function update($id, array $data)
    {
        $isUserExists = $this->userRepository->getById($id);

        if (! $isUserExists) {
            return ['errors' => ['User not found']];
        }

        return $this->userRepository->update($isUserExists, $data);
    }

    public function delete($request): bool
    {
        $isUserExists = $this->userRepository->getById($request->id);

        if (!$isUserExists) {
            return false;
        }

        $this->userRepository->delete($isUserExists);

        return true;
    }
}
