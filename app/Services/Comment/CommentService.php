<?php

namespace App\Services\Comment;

use App\Repositories\Comment\CommentRepository;

class CommentService
{
    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function check($id) {
        return $this->commentRepository->check($id);
    }

    public function getAll(){
        $comments = $this->commentRepository->getAll();
        return $comments;
    }

    public function getBy($id){
        return $this->commentRepository->getBy($id);
    }

    public function create(array $request){
        return $this->commentRepository->create($request);
    }

    public function update(array $data){
        $check = $this->commentRepository->check($data['post_id']);
        return $this->commentRepository->update($check,$data);

    }

    public function delete($id): bool{
        $check = $this->commentRepository->check($id);
        if ($check) {
            return  $this->commentRepository->delete($check);
        } else {
            return false;
        }
    }

    public function getCommentByUser()
    {
        return $this->commentRepository->getCommentByUser();
    }

    public function getTotalCommentsCountByUserId($user_id)
    {
        return $this->commentRepository->getTotalCommentsCountByUserId($user_id);
    }
}
