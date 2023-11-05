<?php

namespace App\Services\Comment;

use App\Models\Comment;
use App\Repositories\Comment\CommentRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isNull;

class CommentService
{
    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getAll(){
        $comments = $this->commentRepository->getAll();
        return $comments;
    }

    public function get($request){
        $id = $request->comment_id;
        $comment = $this->commentRepository->getById($id);

        if(!$comment){
            return response()->json(['errors'=>'Aradığınız yorum bulunamadı']);
        }

        return response()->json(['data'=>$comment]);
    }

    public function create(array $request){
        $validate = Validator::make($request,[
            'user_id'=>'required',
            'post_id'=>'required',
            'comment_text'=>'required',
            'comment_date'=>'required'
        ]);

        if($validate->fails()){
            return response()->json(['errors'=>$validate->errors()],403);
        }
        $result = $this->commentRepository->create($request);

        return response()->json(['data'=>$result],200);
    }

    public function update(Request $request){
        $validate = Validator::make($request->all(),[
            'id'=>'required|exists:comments,id',
            'comment_text'=>'required',
        ]);

        if($validate->fails()){
            return response()->json(['errors'=>$validate->errors()],403);
        }

        $comment = Comment::findOrFail($request->id);
        $comment->comment_text = $request->comment_text;

        $result = $this->commentRepository->update($comment,$request->all());
        return response()->json(['data'=>$result]);
    }

    public function delete(Request $request){
        $validate = Validator::make($request->all(),[
            'comment_id'=>'required|exists:comments,id'
        ]);
        if($validate->fails()){
            return response()->json(['errors'=>$validate->errors()],403);
        }

        $comment = Comment::findOrFail($request->comment_id);

        $result = $this->commentRepository->delete($comment);
        return response()->json(['data'=>$result]);
    }

}
