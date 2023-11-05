<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInterest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_interests';

    protected $fillable = [
        'user_id',
        'interest_id',
    ];
}
