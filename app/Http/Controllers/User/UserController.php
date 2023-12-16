<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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

    public function get(Request $request){
        return $this->userService->get($request);
    }

    public function update(Request $request){
        return $this->userService->update($request->id,$request->except('id'));
    }

    public function delete(Request $request){
        return $this->userService->delete($request);
    }
}
