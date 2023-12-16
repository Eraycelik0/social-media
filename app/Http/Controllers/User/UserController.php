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

    public function get($id){
        return $this->userService->get($id);
    }

    public function update(Request $request){
        return $this->userService->update($request->id,$request->except('id'));
    }

    public function delete($id){
        return $this->userService->delete($id);
    }
}
