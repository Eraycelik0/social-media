<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Services\Comment\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function getAll(){
        return $this->commentService->getAll();
    }

    public function get(Request $request){
        return $this->commentService->get($request);
    }

    public function create(Request $request){
        $req = $request->only
        (
            'user_id',
            'post_id',
            'comment_text',
            'comment_date'
        );
        return $this->commentService->create($req);
    }

    public function update(Request $request){
        return $this->commentService->update($request);
    }

    public function delete(Request $request){
        return $this->commentService->delete($request);
    }
}
