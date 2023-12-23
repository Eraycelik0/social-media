<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Repositories\Comment\CommentRepository;
use App\Services\Comment\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function getCommentsByUser()
    {
        try {
            $comment = $this->commentService->getCommentByUser();
            $totalRecords = $this->commentService->getTotalCommentsCountByUserId(Auth::user()->id);

            if (!$comment) {
                return response()->json(['message' => 'No comment found for this user'], 404);
            }

            $results = [
                'total_records' => $totalRecords,
                'comments' => $comment
            ];

            return response()->json(["data" => $results], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }

    }

    public function getBy(Request $request)
    {
        try {
            $comment = $this->commentService->getBy($request->uuid);
            if (!$comment) return response()->json(['error' => 'not found'], 404);

            return response()->json(['comment' => $comment], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }

    }

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'post_id' => 'required',
                'comment_text' => 'required|string'
            ]);

            $user_id = Auth::id();

            try {
                $parent_id = isset($request->parent_id) ? Crypt::decrypt($request->parent_id) : null;
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Parent comment not found'], 404);
            }

            if (isset($parent_id)) {
                $parentComment = $this->commentService->getBy($parent_id);
                if (!$parentComment) {
                    return response()->json(['error' => 'Parent comment not found'], 404);
                }
            }

            $commentData = [
                'user_id' => $user_id,
                'post_id' => Crypt::decrypt($request->post_id),
                'comment_text' => $request->comment_text,
                'parent_id' => $parent_id,
            ];

            $result = $this->commentService->create($commentData);
            return response()->json(['status' => true, 'message' => $result]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $data = $request->all();
            $result = $this->commentService->update($data);
            return response()->json(['user' => $result], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function delete(Request $request) {
        try {
            $result = $this->commentService->delete($request->uuid);

            if (!$result) return response()->json(['status'=> false,'message' => 'Comment not found'], 404);
            else return response()->json(['status'=> true,'message' => 'Comment deleted']);

        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
