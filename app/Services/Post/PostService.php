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
        $check = $this->postRepository->getById($data['post_id']);
        return $this->postRepository->update($check, $data);
    }
    public function delete($id): bool {
        $check = $this->postRepository->getById($id);
        if ($check) {
            return  $this->postRepository->delete($check);
        } else {
            return false;
        }
    }
    public function getById($id)
    {
        return $this->postRepository->getById($id);
    }
    public function getAll()
    {
        return $this->postRepository->getAll();
    }
    public function getPostsByUserId($user_id)
    {
        return $this->postRepository->getPostsByUserId($user_id);
    }
    public function getTotalPostsCountByUserId($user_id)
    {
        return $this->postRepository->getTotalPostsCountByUserId($user_id);
    }
}
