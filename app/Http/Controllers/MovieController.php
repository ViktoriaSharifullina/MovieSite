<?php

namespace App\Http\Controllers;

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

        return view('movies/movie', $movieData);
    }
}
