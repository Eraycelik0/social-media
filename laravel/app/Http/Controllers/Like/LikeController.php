<?php

namespace App\Http\Controllers\Like;

use App\Http\Controllers\Controller;
use App\Services\Like\LikeService;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    protected $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    public function getAll(){
        return $this->likeService->getAll();
    }

    public function get(Request $request){
        return $this->likeService->get($request);
    }

    public function create(Request $request){
        return $this->likeService->create($request);
    }

    public function update(Request $request){
        return $this->likeService->update($request);
    }

    public function delete(Request $request){
        return $this->likeService->delete($request);
    }
}
