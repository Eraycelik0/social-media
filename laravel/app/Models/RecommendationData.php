<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecommendationData extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'recommendation_data';

    protected $fillable = [
        'user_id',
        'interest_id',
        'content_type',
        'content_id',
        'recommendation_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function interest()
    {
        return $this->belongsTo(Interest::class, 'interest_id', 'interest_id');
    }
}
