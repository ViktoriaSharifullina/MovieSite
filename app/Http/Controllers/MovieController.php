<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use App\Services\RatingService;
use Illuminate\Support\Facades\Auth;
use App\Http\Contracts\MovieServiceInterface;


class MovieController extends Controller
{

    private MovieServiceInterface $movieService;
    protected RatingService $ratingService;

    public function __construct(MovieServiceInterface $movieService, RatingService $ratingService)
    {
        $this->movieService = $movieService;
        $this->ratingService = $ratingService;
    }

    public function index()
    {
        $moviesData = $this->movieService->getMoviesData();

        return view('home', $moviesData);
    }

    public function aboutMovie(int $id)
    {
        $movieDetails = $this->movieService->getMovieDetailsAndActors($id);

        $movie = $movieDetails['movie'];
        $mainActors = $movieDetails['mainActors'];

        $isInWatchLater = false;
        $isFavorite = false;
        $userRating = null;

        if (Auth::check()) {
            $user = Auth::user();
            $isInWatchLater = $user->isInWatchLater($id);
            $isFavorite = $user->isFavorite($id);
            $userRating = $this->ratingService->getUserRating($id);
        }

        return view('movies.about', compact('movie', 'mainActors', 'isInWatchLater', 'isFavorite', 'userRating'));
    }

    public function catalogBasic(Request $request)
    {
        $sort = $request->query('sort_by', 'popular');
        $moviesData = $this->movieService->getMoviesByFilter($sort);

        return view('movies.catalog', ['moviesData' => $moviesData, 'currentSort' => $sort]);
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

        $moviesData = $this->movieService->getMoviesFilteredAndSorted($filterParams, $page);

        return view('movies.catalog', [
            'moviesData' => $moviesData['movies'],
            'currentSort' => $request->input('sort_by', 'popularity.desc'),
            'currentPage' => $moviesData['current_page'],
            'totalPages' => $moviesData['total_pages'],
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $moviesData = $this->movieService->searchMovies($query);

        return view('movies.catalog', [
            'moviesData' => $moviesData,
            'currentSort' => 'search',
        ]);
    }
}
