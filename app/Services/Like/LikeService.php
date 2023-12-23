<?php

namespace App\Services\Like;

use Illuminate\Http\Request;
use App\Services\Post\PostService;
use Illuminate\Support\Facades\Crypt;
use App\Repositories\Like\LikeRepository;
use Illuminate\Support\Facades\Validator;

class LikeService
{
    protected $likeRepository;
    protected $postService;
    public function __construct(LikeRepository $likeRepository, PostService $postService)
    {
        $this->likeRepository = $likeRepository;
        $this->postService = $postService;
    }
    public function getAll()
    {
        return $this->likeRepository->getAll();
    }
    public function get(Request $request)
    {
        return $this->likeRepository->getById($request->like_id);
    }
    public function create($data) {
        return $this->likeRepository->create($data);
    }
    public function delete($id) {
        $like = $this->likeRepository->getById(Crypt::decrypt($id));
        if($like) {
            return $this->likeRepository->delete($like);
        } else return false;
    }
}
