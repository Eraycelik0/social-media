<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class Like extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'likes';
    protected $fillable = [
        'user_id',
        'post_id',
        'comment_id',
        'story_id'
    ];

    protected $hidden = [
        'id',
        'post_id',
        'user_id',
        'comment_id',
        'story_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function getEncryptedIdAttribute(){
        // return openssl_encrypt($this->attributes['id'], 'aes-256-cbc', env('APP_NAME'), 0, openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc')));
        return Crypt::encrypt($this->attributes['id']);
    }
}
