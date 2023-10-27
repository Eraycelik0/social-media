<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Services\MediaShare\MediaShareService;
use App\Services\Post\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;
    protected $mediaShareService;

    public function __construct(PostService $postService, MediaShareService $mediaShareService)
    {
        $this->postService = $postService;
        $this->mediaShareService = $mediaShareService;
    }

    public function create(Request $request)
    {
        $data = $request->all();

        if ($request->has('media')) {
            $mediaResult = $this->mediaShareService->createMediaShare($data);
            if (isset($mediaResult['errors'])) {
                return response()->json(['errors' => $mediaResult['errors']], 400);
            }

            $data['media'] = $mediaResult['media'];
        }

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

        if ($request->has('media_share_id')) {
            $mediaShareId = $request->input('media_share_id');
            $mediaRequestData = $data['media'];

            $mediaRequest = new Request(['user_id' => $mediaRequestData['user_id'], 'media_type' => $mediaRequestData['type'], 'media_url' => $mediaRequestData['file']]);

            $mediaResult = $this->mediaShareService->updateMediaShare($mediaRequest, $mediaShareId);
            if (isset($mediaResult['errors'])) {
                return response()->json(['errors' => $mediaResult['errors']], 400);
            }
        }

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

        return response()->json([], 204);
    }
}
