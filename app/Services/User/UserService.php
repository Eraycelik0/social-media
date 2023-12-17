<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;
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

    public function get($id)
    {
        $isUserExists = $this->userRepository->getById($id);

        if (!$isUserExists) {
            return response('Kullanıcı Bulunamadı!',404);
        }

        return $isUserExists;
    }

    public function update($id, array $data)
    {
        $isUserExists = $this->userRepository->getById($id);

        if (! $isUserExists) {
            return ['errors' => ['User not found']];
        }

        $validate = Validator::make($data,[
            'first_name'=>'required',
            'last_name'=>'required',
            'username'=>'required|unique:users',
            'description'=>'',
            'date_of_birth'=>'date|date_format:d.m.Y',
            'title'=>'',
        ]);

        if($validate->fails()){
            return response($validate->errors(),400);
        }

        return $this->userRepository->update($isUserExists, $data);
    }

    public function delete($id): bool
    {
        $isUserExists = $this->userRepository->getById($id);

        if (!$isUserExists) {
            return false;
        }

        $this->userRepository->delete($isUserExists);

        return true;
    }
}
