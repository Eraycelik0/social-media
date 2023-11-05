<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Follower extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'followers';
    protected $fillable = [
        'following_id',
        'followed_id',
        'follow_date',
    ];

    public function followerUser()
    {
        return $this->belongsTo(User::class, 'following_id', 'id');
    }

    public function followedUser()
    {
        return $this->belongsTo(User::class, 'followed_id', 'id');
    }
}
