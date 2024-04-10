<?php

namespace App\Http\Controllers;

use App\Services\TvService;
use Illuminate\Http\Request;
use App\Services\RatingService;
use Illuminate\Support\Facades\Auth;

class TvController extends Controller
{
    private TvService $tvService;
    protected RatingService $ratingService;

    public function __construct(TvService $tvService, RatingService $ratingService)
    {
        $this->tvService = $tvService;
        $this->ratingService = $ratingService;
    }

    public function aboutTv(int $id)
    {
        $tvDetails = $this->tvService->getTvDetailsAndActors($id);

        $tv = $tvDetails['tv'];
        $mainActors = $tvDetails['mainActors'];

        $isInWatchLater = false;
        $isFavorite = false;
        $userRating = null;

        if (Auth::check()) {
            $user = Auth::user();
            $isInWatchLater = $user->isInWatchLater($id);
            $isFavorite = $user->isFavorite($id);
            $userRating = $this->ratingService->getUserRating($id);
        }

        // dd($tv);
        return view('series.about', compact('tv', 'mainActors', 'isInWatchLater', 'isFavorite', 'userRating'));
    }

    public function catalogBasic(Request $request)
    {
        $sort = $request->query('sort', 'popular');
        $tvData = $this->tvService->getTvByFilter($sort);

        return view('series.catalog', ['tvData' => $tvData, 'currentSort' => $sort]);
    }

    public function catalogAdvanced(Request $request)
    {
        $filterParams = [
            'sort_by' => $request->input('sort_by'),
            'with_genres' => $request->input('genre'),
            'with_original_language' => $request->input('language'),
            'primary_release_date.gte' => $request->input('release_date_gte'),
            'primary_release_date.lte' => $request->input('release_date_lte'),
        ];

        $page = $request->input('page', 1);

        $tvData = $this->tvService->getTvFilteredAndSorted($filterParams, $page);

        return view('movies.catalog', [
            'moviesData' => $tvData['movies'],
            'currentSort' => $request->input('sort_by', 'popularity.desc'),
            'currentPage' => $tvData['current_page'],
            'totalPages' => $tvData['total_pages'],
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $tvData = $this->tvService->searchTv($query);

        return view('series.catalog', [
            'tvData' => $tvData,
            'currentSort' => 'search',
        ]);
    }
}
