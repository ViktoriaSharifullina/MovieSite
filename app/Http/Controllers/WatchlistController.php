<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WatchlistService;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    protected $watchlistService;

    public function __construct(WatchlistService $watchlistService)
    {
        $this->watchlistService = $watchlistService;
    }

    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'You must be logged in to perform this action'], 403);
        }

        $user = Auth::user();
        $status = $this->watchlistService->toggleWatchlist($user, $request->movie_tmdb_id, $request->list_type);

        return response()->json(['status' => $status]);
    }
}
