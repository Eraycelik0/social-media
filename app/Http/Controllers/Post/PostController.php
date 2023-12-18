<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Services\Media\MediaService;
use App\Services\Post\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    protected $mediaService;
    protected $postService;

    public function __construct(PostService $postService, MediaService $mediaService) {
        $this->postService = $postService;
        $this->mediaService = $mediaService;
    }
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'post_text' => 'required',
            'media_share.*' => 'mimes:jpg,jpeg,png,mp4,mov|max:8024',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $data = $request->all();
            $processedMedia = [];
            if ($request->hasFile('media_share')) {
                foreach ($request->file('media_share') as $file) {
                    $processedMedia[] = $this->mediaService->processFile($file);
                }
            }

            if(in_array(null, $processedMedia)) {
                foreach ($processedMedia as $media) {
                    if(!is_null($media)) {
                        Storage::delete($media);
                    }
                } return response()->json(['status' => false, 'errors' => 'Invalid file type'], 400);
            }

            $data['media_share'] = json_encode($processedMedia, JSON_UNESCAPED_SLASHES);
            $data['user_id'] = Auth::user()->id;

            $result = $this->postService->create($data);

            return response()->json(['user' => $result], 201);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
    public function update(Request $request) {
        try {
            $data = $request->all();
            if(isset($data['media_share'])) unset($data['media_share']);

            $result = $this->postService->update($data);

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
    public function delete(Request $request) {
        try {
            $result = $this->postService->delete($request->post_id);

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
