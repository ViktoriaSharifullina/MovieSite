<?php

namespace App\Services;

use App\Models\User;
use App\Services\TvService;
use App\Services\MovieService;
use App\Services\RatingService;

class UserProfileService
{
    protected $movieService;
    protected $ratingService;
    protected $tvService;

    public function __construct(MovieService $movieService, RatingService $ratingService, TvService $tvService)
    {
        $this->movieService = $movieService;
        $this->ratingService = $ratingService;
        $this->tvService = $tvService;
    }

    public function getListDetailsByType(User $user, string $listType): array
    {
        $watchlistItems = $user->watchlists()->where('list_type', $listType)->get();

        $moviesDetails = [];
        foreach ($watchlistItems as $item) {
            if ($item->media_type === 'movie') {
                $movieDetails = $this->movieService->getInfoMovie($item->movie_tmdb_id);
            } elseif ($item->media_type === 'tv') {
                $movieDetails = $this->tvService->getInfoTv($item->movie_tmdb_id);
            }

            if ($movieDetails) {
                $userRating = $this->ratingService->getUserRating($user->id, $movieDetails['id'], $item->media_type);
                $movieDetails['user_rating'] = $userRating ? $userRating->rating_value : null;
                $moviesDetails[] = $movieDetails;
            }
        }

        return $moviesDetails;
    }
}
