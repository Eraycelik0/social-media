<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Services\Images\ImagesService;
use App\Services\Post\PostService;
use App\Services\Videos\VideoService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;
    protected $imageService;
    protected $videoService;
    public function __construct(PostService $postService, ImagesService $imageService, VideoService $videoService)
    {
        $this->postService = $postService;
        $this->imageService = $imageService;
        $this->videoService = $videoService;
    }
    public function create(Request $request)
    {
        try {
            $data = $request->all();

//            if($data['media_photo_url'] != null){
//                $data['media_photo_url'] = $this->imageService->processImage($request);
//            }
//
//            if($data['media_video_url'] != null){
//                $data['media_video_url'] = $this->videoService->processVideo($request);
//            }

            $result = $this->postService->create($data);

            return response()->json(['user' => $result], 201);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
    public function update(Request $request)
    {
        try {
            $data = $request->all();
            $id = $request->input('id');
            $data['media_photo_url'] = $this->imageService->processUpdateImage($request);
            $data['media_video_url'] = $this->videoService->processUpdateVideo($request);

            $result = $this->postService->update($id, $data);

            return response()->json(['user' => $result], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
    public function getById(Request $request)
    {
        try {
            $id = $request->input('id');
            $user = $this->postService->getById($id);

            if (!$user) {
                return response()->json(['error' => 'User does not have any posts.'], 404);
            }

            return response()->json(['user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
    public function delete(Request $request)
    {
        try {
            $id = $request->input('id');
            $result = $this->postService->delete($id);

            if (!$result) {
                return response()->json(['errors' => ['Post not found']], 404);
            }

            return response()->json(["Post Successfully deleted"], 204);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
    public function getPostsByUserId(Request $request)
    {
        try {
            $user_id = $request->input('user_id');
            $posts = $this->postService->getPostsByUserId($user_id);
            $totalRecords = $this->postService->getTotalPostsCountByUserId($user_id);

            if (!$posts) {
                return response()->json(['message' => 'No posts found for this user.'], 404);
            }

            $results = [
                'total_records' => $totalRecords,
                'posts' => $posts,
            ];

            return response()->json(["data" => $results], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
