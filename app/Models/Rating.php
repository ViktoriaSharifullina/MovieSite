<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'user_id',
        'movie_tmdb_id',
        'rating_value',
        'media_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}