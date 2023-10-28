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
        $data = $request->all();

        $data['media_photo_url'] = $this->imageService->processImage($request);
        $data['media_video_url'] = $this->videoService->processVideo($request);

        $result = $this->postService->create($data);

        if (isset($result['errors'])) {
            return response()->json(['errors' => $result['errors']], 400);
        }

        return response()->json(['user' => $result], 201);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $id = $request->input('user_id');
        $data['media_photo_url'] = $this->imageService->processUpdateImage($request);
        $data['media_video_url'] = $this->videoService->processUpdateVideo($request);

        $result = $this->postService->update($id, $data);

        if (isset($result['errors'])) {
            return response()->json(['errors' => $result['errors']], 400);
        }

        if (isset($result['errors']) && in_array('User not found', $result['errors'])) {
            return response()->json(['errors' => $result['errors']], 404);
        }

        return response()->json(['user' => $result], 200);
    }

    public function getById(Request $request)
    {
        $id = $request->input('id');
        $user = $this->postService->getById($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json(['user' => $user], 200);
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        $result = $this->postService->delete($id);

        if (!$result) {
            return response()->json(['errors' => ['User not found']], 404);
        }

        return response()->json(["Post Successfully deleted"], 204);
    }
}
