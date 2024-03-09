<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MovieService;

class MovieController extends Controller
{

    private $movieService;

    public function __construct(MovieService $movieService)
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
        // dd($request);
        $moviesData = $this->movieService->getMoviesFilteredAndSorted($request);

        return view('movies.catalog', [
            'moviesData' => $moviesData['movies'],
            'currentSort' => $request->input('sort_by', 'popularity.desc'),
            'currentPage' => $moviesData['current_page'],
            'totalPages' => $moviesData['total_pages'],
        ]);
    }
}
