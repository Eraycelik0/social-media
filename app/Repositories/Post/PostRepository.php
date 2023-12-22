<?php

namespace App\Repositories\Post;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


class PostRepository implements PostInterface {
    public function check($id) {
        return Post::with('user')->where('id', Crypt::decrypt($id))->where('user_id', auth()->user()->id)->first();
    }

    public function create(array $data): Post {
        $post = Post::create($data);
        $post = Post::with('user')->where('id', $post->id)->first();
        $post->uuid = $post->encrypted_id;
        return $post;
    }

    public function update(Post $post, array $data): Post {
        $post->update($data);
        return $post;
    }

    public function delete(Post $post): bool {
        return $post->delete();
    }
    public function getBy($id): ?Post {
        $post =  Post::with('user')->where('id', Crypt::decrypt($id))->first();
        $post->uuid = $post->encrypted_id;
        return $post;
    }
    public function getAll()
    {
        return Post::get();
    }
    public function getPostsByUser() {
        $posts = Post::with('user')->where('user_id', Auth::user()->id)->get();

        $posts->each(function ($post) {
            $post->uuid = $post->encrypted_id;
        });

        return $posts;
    }
    public function getTotalPostsCountByUserId($user_id)
    {
        return Post::where('user_id', $user_id)->count();
    }
}
