<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class WatchlistService
{
    public function toggleWatchlist(User $user, $movieId, $listType, $mediaType)
    {
        $entry = $user->watchlists()
            ->where('movie_tmdb_id', $movieId)
            ->where('media_type', $mediaType)
            ->where('list_type', $listType)
            ->first();

        if ($entry) {
            $entry->delete();
            return 'removed';
        } else {
            $user->watchlists()->create([
                'movie_tmdb_id' => $movieId,
                'media_type' => $mediaType,
                'list_type' => $listType,
            ]);
            return 'added';
        }
    }
}
