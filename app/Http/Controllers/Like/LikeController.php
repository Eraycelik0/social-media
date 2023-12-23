<?php

namespace App\Http\Controllers\Like;

use App\Http\Controllers\Controller;
use App\Services\Like\LikeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;


class LikeController extends Controller
{
    protected $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    public function getAll()
    {
        return $this->likeService->getAll();
    }

    public function get(Request $request)
    {
        return $this->likeService->get($request);
    }

    public function create(Request $request) {
        $validate = Validator::make($request->all(), [
            'type' => 'required|in:post,story,comment',
        ]);

        if ($validate->fails()) {
            return ['errors' => $validate->errors()];
        } else {
            $data = $request->all();
            $data['user_id'] = Auth::user()->id;
            try {
                $id = Crypt::decrypt($request->content_id);
            } catch (\Throwable $th) {
                return response()->json(['error' => 'like not found'], 404);
            }

            switch($request->type) {
                case 'comment':
                    $data['comment_id'] = $id;
                    break;
                case 'post':
                    $data['post_id'] = $id;
                    break;
                case 'story':
                    $data['story_id'] = $id;
                    break;
                default:
                    break;
            }

            $result = $this->likeService->create($data);
            if($result) {
                return response()->json(['status'=> true,'message' => 'liked']);
            } else {
                return response()->json(['status'=> false,'message' =>'operation failed']);
            }
        }
    }

    public function delete(Request $request) {
        $result = $this->likeService->delete($request->like_id);
        if($result) {
            return response()->json(['status'=> true,'message' => 'unliked']);
        } else {
            return response()->json(['status'=> false,'message' =>'operation failed']);
        }
    }
}
