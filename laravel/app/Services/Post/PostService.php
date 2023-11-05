<?php

namespace App\Services\Post;

use App\Repositories\Post\PostRepository;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function create(array $data)
    {
        return $this->postRepository->create($data);
    }

    public function update($id, array $data)
    {
        $data['id'] = $id;
        $signIn = $this->postRepository->getById($id);

        if (!$signIn) {
            return ['errors' => ['User not found']];
        }

        return $this->postRepository->update($signIn, $data);
    }

    public function delete($id): bool
    {
        $signIn = $this->postRepository->getById($id);

        if (!$signIn) {
            return false;
        }

        $this->postRepository->delete($signIn);

        return true;
    }


    public function getById($id)
    {
        return $this->postRepository->getById($id);
    }


    public function getAll()
    {
        return $this->postRepository->getAll();
    }
}
