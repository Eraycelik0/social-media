<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'interests';
    protected $fillable = [
        'interest_name',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_interests', 'interest_id', 'user_id');
    }

    public function recommendations()
    {
        return $this->hasMany(RecommendationData::class, 'interest_id', 'interest_id');
    }
}
