<?php

namespace App\Services;

use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingService
{
    public function setRating($userId, $movieId, $ratingValue)
    {
        $rating = Rating::updateOrCreate(
            [
                'user_id' => $userId,
                'movie_tmdb_id' => $movieId,
            ],
            ['rating_value' => $ratingValue]
        );

        return ['status' => 'Rating set', 'rating' => $rating];
    }

    public function removeRating($userId, $movieId)
    {
        $result = Rating::where('user_id', $userId)
            ->where('movie_tmdb_id', $movieId)
            ->delete();

        if ($result) {
            return ['status' => 'Rating removed'];
        } else {
            return ['status' => 'Rating not found or already removed'];
        }
    }

    public function getUserRating($movieId)
    {
        if (!Auth::check()) {
            return null;
        }

        return Rating::where('user_id', Auth::id())
            ->where('movie_tmdb_id', $movieId)
            ->first();
    }
}
