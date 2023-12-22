<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getAll(){
        return $this->userService->getAll();
    }

    public function get($username){
        return $this->userService->get($username);
    }

    public function search($username){
        return $this->userService->get($username);
    }
}
