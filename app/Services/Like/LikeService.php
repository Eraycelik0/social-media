<?php

namespace App\Services\Like;

use App\Repositories\Like\LikeRepository;
use App\Services\Post\PostService;
use Illuminate\Http\Request;
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
    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required',
            'post_id' => 'required',
        ]);

        if ($validate->fails()) {
            return ['errors' => $validate->errors()];
        }

        $result = $this->likeRepository->create($request->all());

        $this->postService->incrementLikeCount($request->post_id);

        return ['data' => $result];
    }
    public function delete(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'like_id' => 'required',
        ]);

        if ($validate->fails()) {
            return ['errors' => $validate->errors()];
        }

        $tempLike = $this->likeRepository->getById($request->like_id);

        $this->postService->decrementLikeCount($tempLike->post_id);

        $result = $this->likeRepository->delete($tempLike);

        return $result;
    }
}
