<?php
namespace App\Services\Post;

use App\Repositories\Post\PostRepository;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository) {
        $this->postRepository = $postRepository;
    }

    public function check($id) {
        return $this->postRepository->check($id);
    }

    public function create(array $data) {
        return $this->postRepository->create($data);
    }

    public function update(array $data) {
        $check = $this->postRepository->check($data['post_id']);
        return $this->postRepository->update($check, $data);
    }
    public function delete($id): bool {
        $check = $this->postRepository->check($id);
        if ($check) {
            return  $this->postRepository->delete($check);
        } else {
            return false;
        }
    }
    public function getBy($id)
    {
        return $this->postRepository->getBy($id);
    }
    public function getAll()
    {
        return $this->postRepository->getAll();
    }
    public function getPostsByUser()
    {
        return $this->postRepository->getPostsByUser();
    }
    public function getTotalPostsCountByUserId($user_id)
    {
        return $this->postRepository->getTotalPostsCountByUserId($user_id);
    }
}
