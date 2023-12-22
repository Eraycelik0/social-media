<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'posts';

    protected $hidden = [
        'id',
        'user_id',
        'pinned_post_id',
        'deleted_at',
    ];
    
    protected $fillable = [
        'user_id',
        'post_text',
        'like_count',
        'comment_count',
        'share_count',
        'pinned_post_id',
        'media_share'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function getEncryptedIdAttribute(){
        // return openssl_encrypt($this->attributes['id'], 'aes-256-cbc', env('APP_NAME'), 0, openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc')));
        return Crypt::encrypt($this->attributes['id']);
    }
}
