<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\RatingService;

class RatingController extends Controller
{
    protected $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    public function toggle(RatingRequest $request)
    {
        $validated = $request->validated();
        $userId = Auth::id();
        $movieId = $validated['movie_tmdb_id'];
        $ratingValue = $validated['rating_value'];
        $mediaType = $validated['media_type'];

        if ($ratingValue == 0) {
            $response = $this->ratingService->removeRating($userId, $movieId, $mediaType);
        } else {
            $response = $this->ratingService->setRating($userId, $movieId, $ratingValue, $mediaType);
        }

        return response()->json($response);
    }
}
