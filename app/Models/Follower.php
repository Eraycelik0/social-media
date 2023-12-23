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
        'from',
        'to',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'to', 'id');
    }

    public function followerUser()
    {
        return $this->belongsTo(User::class, 'from', 'id');
    }
}
