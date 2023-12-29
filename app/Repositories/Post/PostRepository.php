<?php

namespace App\Repositories\Post;

use App\Models\Post;
use Illuminate\Support\Str;
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
        $post = Post::with('user', 'comments', 'likes')->where('id', Crypt::decrypt($id))->first();
        $post->uuid = $post->encrypted_id;

        $post->comment_count = count($post->comments);
        $post->like_count = count($post->likes);
        foreach ($post->comments as $comment) {
            $comment->uuid = $comment->encrypted_id;
        }

        foreach ($post->likes as $like) {
            $like->uuid = $like->encrypted_id;
        }
        return $post;
    }
    public function getAll()
    {
        $posts = Post::with('user', 'comments', 'likes')->get();

        // Her bir post için şifrelenmiş ve şifrelenmemiş id değerlerini ekleyelim
        $posts = $posts->map(function ($post) {
            $post->uuid = $post->getEncryptedIdAttribute(); // Şifrelenmiş ID değeri
            return $post;
        });

        return $posts;
    }
    public function getPostsByUser() {
        $posts = Post::with('user', 'comments', 'likes')->where('user_id', Auth::user()->id)->get();

        $posts->each(function ($post) {
            $post->uuid = $post->encrypted_id;
            $post->comment_count = count($post->comments);
            $post->like_count = count($post->likes);
            foreach ($post->comments as $comment) {
                $comment->uuid = $comment->encrypted_id;
            }
            foreach ($post->likes as $like) {
                $like->uuid = $like->encrypted_id;
            }
        });

        return $posts;
    }
    public function getTotalPostsCountByUserId($user_id)
    {
        return Post::where('user_id', $user_id)->count();
    }
}
