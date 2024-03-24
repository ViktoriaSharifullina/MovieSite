<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Contracts\MovieServiceInterface;

class MovieController extends Controller
{

    private MovieServiceInterface $movieService;

    public function __construct(MovieServiceInterface $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index()
    {
        $moviesData = $this->movieService->getMoviesData();

        return view('home', $moviesData);
    }

    public function aboutMovie(int $id)
    {
        $movieData = $this->movieService->getMovieDetailsAndActors($id);

        return view('movies/about', $movieData);
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
