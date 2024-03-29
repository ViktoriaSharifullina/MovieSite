<?php

namespace App\Services;

use App\Models\User;
use App\Models\Watchlist;

class WatchlistService
{
    public function toggleWatchlist(User $user, $movieId, $listType)
    {
        $entry = $user->watchlists()
            ->where('movie_tmdb_id', $movieId)
            ->where('list_type', $listType)
            ->first();

        if ($entry) {
            $entry->delete();
            return 'removed';
        } else {
            $user->watchlists()->create([
                'movie_tmdb_id' => $movieId,
                'list_type' => $listType,
            ]);
            return 'added';
        }
    }
}
