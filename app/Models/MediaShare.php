<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaShare extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'media_shares';
    protected $primaryKey = 'media_id';
    protected $fillable = [
        'user_id',
        'media_type',
        'media_url',
        'share_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
