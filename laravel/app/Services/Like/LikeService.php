<?php

namespace App\Services\Like;

use App\Repositories\Like\LikeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LikeService
{
    protected $likeRepository;

    public function __construct(LikeRepository $likeRepository)
    {
        $this->likeRepository = $likeRepository;
    }

    public function getAll(){
        return $this->likeRepository->getAll();
    }

    public function get(Request $request){
        return $this->likeRepository->getById($request);
    }

    public function create(Request $request){
        $validate = Validator::make($request->all(),[
            'user_id'=>'required',
            'post_id'=>'required',
        ]);

        if($validate->fails()){
            return response()->json(['errors'=>$validate->errors()],403);
        }
        $result = $this->likeRepository->create($request->all());

        return response()->json(['data'=>$result],200);
    }

    public function delete(Request $request){
        $validate = Validator::make($request->all(),[
            'like_id'=>'required',
        ]);

        if($validate->fails()){
            return response()->json(['errors'=>$validate->errors()],403);
        }

        $tempLike = $this->likeRepository->getById($request->like_id);

        return $this->likeRepository->delete($tempLike);
    }
}
