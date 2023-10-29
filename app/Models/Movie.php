<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $table = 'movies';

    protected $fillable = [
        'genres',
        'homepage',
        'keywords'  ,
        'original_language',
        'original_title',
        'popularity',
        'production_companies',
        'production_countries',
        'overview',
        'release_date',
        'revenue',
        'runtime',
        'spoken_languages',
        'status',
        'tagline',
        'title',
        'vote_average',
        'vote_count',
    ];
}
