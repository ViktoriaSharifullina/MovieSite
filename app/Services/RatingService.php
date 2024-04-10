<?php

namespace App\Services;

use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingService
{
    public function setRating($userId, $movieId, $ratingValue, $mediaType)
    {
        $rating = Rating::updateOrCreate(
            [
                'user_id' => $userId,
                'movie_tmdb_id' => $movieId,
                'media_type' => $mediaType,
            ],
            ['rating_value' => $ratingValue]
        );

        return ['status' => 'Rating set', 'rating' => $rating];
    }

    public function removeRating($userId, $movieId, $mediaType)
    {
        $result = Rating::where('user_id', $userId)
            ->where('movie_tmdb_id', $movieId)
            ->where('media_type', $mediaType)
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
