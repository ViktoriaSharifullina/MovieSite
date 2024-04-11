<?php

namespace App\Services;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewService
{
    public function saveReview($data)
    {
        $review = new Review();
        $review->user_id = Auth::id();
        $review->movie_tmdb_id = $data['movie_tmdb_id'];
        $review->media_type = $data['media_type'];
        $review->comment = $data['comment'];
        $review->save();

        return $review;
    }
}
