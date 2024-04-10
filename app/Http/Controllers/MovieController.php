<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MovieService;
use App\Services\RatingService;
use App\Services\UserProfileService;
use Illuminate\Support\Facades\Auth;


class MovieController extends Controller
{

    private MovieService $movieService;
    protected RatingService $ratingService;
    protected UserProfileService $userProfileService;

    public function __construct(MovieService $movieService, RatingService $ratingService, UserProfileService $userProfileService)
    {
        $this->movieService = $movieService;
        $this->ratingService = $ratingService;
        $this->userProfileService = $userProfileService;
    }

    public function index()
    {
        $moviesData = $this->movieService->getContentData();

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
        $sort = $request->query('sort', 'popular');
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

    public function showList(Request $request, $listType)
    {
        $user = Auth::user();
        $seriesCount = $user->seriesCount();
        $moviesCount = $user->moviesCount();
        $favoriteCount = $user->favoriteCount();
        $watchLaterCount = $user->watchLaterCount();
        $moviesDetails = $this->userProfileService->getListDetailsByType($user, $listType);

        // dd($moviesDetails);
        return view('profile.user-profile', [
            'movies' => $moviesDetails,
            'user' => $user,
            'listType' => $listType,
            'moviesCount' => $moviesCount,
            'seriesCount' => $seriesCount,
            'favoriteCount' => $favoriteCount,
            'watchLaterCount' => $watchLaterCount
        ]);
    }

    public function showMovies(Request $request)
    {
        $user = Auth::user();
        $seriesCount = $user->seriesCount();
        $moviesCount = $user->moviesCount();
        $favoriteCount = $user->favoriteCount();
        $watchLaterCount = $user->watchLaterCount();

        $movies = $this->movieService->getUserMoviesWithRatings($user->id);

        return view('profile.user-profile', [
            'movies' => $movies,
            'user' => $user,
            'moviesCount' => $moviesCount,
            'seriesCount' => $seriesCount,
            'favoriteCount' => $favoriteCount,
            'watchLaterCount' => $watchLaterCount
        ]);
    }
}
