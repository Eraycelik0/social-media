<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Repositories\Comment\CommentRepository;
use App\Services\Comment\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                'post_id' => 'required|exists:posts,id',
                'comment_text' => 'required|string',
                'parent_id' => 'nullable|exists:comments,id',
            ]);

            $user_id = Auth::id();

            $parent_id = $validatedData['parent_id'] ?? null;

            if ($parent_id) {
                $parentComment = $this->commentService->getBy($parent_id);
                if (!$parentComment) {
                    return response()->json(['error' => 'Parent comment not found'], 404);
                }
            }

            $commentData = [
                'user_id' => $user_id,
                'post_id' => $validatedData['post_id'],
                'comment_text' => $validatedData['comment_text'],
                'parent_id' => $parent_id,
            ];

            $result = $this->commentService->create($commentData);

            return response()->json($result, $result['status'] === 'success' ? 201 : 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createChildComment(Request $request, $parentCommentId)
    {
        try {
            $parentComment = $this->commentService->getBy($parentCommentId);

            if (!$parentComment) {
                return response()->json(['error' => 'Parent comment not found'], 404);
            }

            $validatedData = $request->validate([
                'post_id' => 'required|exists:posts,id',
                'comment_text' => 'required|string',
            ]);

            $commentData = [
                'user_id' => Auth::id(),
                'post_id' => $validatedData['post_id'],
                'comment_text' => $validatedData['comment_text'],
                'parent_id' => $parentComment->id,
            ];
            $result = $this->commentService->create($commentData);

            return response()->json($result, $result['status'] === 'success' ? 201 : 400);
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

    public function delete(Request $request)
    {
        try {
            $result = $this->commentService->delete($request->uuid);

            if ($result) return response()->json(['status'=> true, "Comment Successfully deleted"], 204);
            else return response()->json(['status'=> false,'message' => 'Comment not found'], 404);

        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
