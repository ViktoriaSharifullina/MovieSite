<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class MovieController extends Controller
{

    public function index()
    {
        $response = Http::get('https://api.themoviedb.org/3/discover/movie', [
            'api_key' => config('services.tmdb.api_key'),
            'sort_by' => 'popularity.desc',
        ]);

        $movies = $response->json()['results'];
        $featuredMovie = $this->getFeaturedMovie($movies[0]);
        $otherMovies = $this->getOtherMovies($movies);

        return view('home', compact('featuredMovie', 'otherMovies'));
    }

    // public function index($start = 0)
    // {
    //     $response = Http::get('https://api.themoviedb.org/3/discover/movie', [
    //         'api_key' => config('services.tmdb.api_key'),
    //         'sort_by' => 'popularity.desc',
    //         'page' => $start / 20 + 1,
    //     ]);

    //     $movies = $response->json()['results'];
    //     $featuredMovie = $this->getFeaturedMovie($movies[0]);
    //     $otherMovies = $this->getOtherMovies($movies);

    //     return view('home', compact('featuredMovie', 'otherMovies', 'start'));
    // }

    public function getFeaturedMovie($movie)
    {
        $movieDetails = $this->getMovieDetails($movie['id']);

        if ($movieDetails) {
            $movie['genre_names'] = $this->getGenresName($movieDetails['genres']);
            $movie['formatted_release_date'] = $this->getFormattedDate($movieDetails['release_date']);
            $movie['formatted_runtime'] = $this->getFormattedRuntime($movieDetails['runtime']);
        }

        return $movie;
    }

    public function getOtherMovies($movies)
    {
        foreach ($movies as &$movie) {
            $movieDetails = $this->getMovieDetails($movie['id']);

            if ($movieDetails) {
                $movie['primary_genre'] = $this->getGenresName($movieDetails['genres'])[0];
                $movie['release_year'] = $this->getReleaseYear($movieDetails['release_date']);
            }
        }

        return $movies;
    }

    public function getMovieDetails(int $movieId)
    {
        $movieDetailsResponse = Http::get("https://api.themoviedb.org/3/movie/{$movieId}", [
            'api_key' => config('services.tmdb.api_key')
        ]);

        $movieDetails = $movieDetailsResponse->json();

        return $movieDetails;
    }

    public function getGenresName(array $genreIds)
    {
        $genreNames = collect($genreIds)->pluck('name')->toArray();

        return $genreNames;
    }

    public function getFormattedDate($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    public function getReleaseYear($date)
    {
        return Carbon::parse($date)->format('Y');
    }

    public function getFormattedRuntime($runtime)
    {
        $hours = floor($runtime / 60);
        $minutes = $runtime % 60;

        $formattedRuntime = '';

        if ($hours > 0) {
            $formattedRuntime .= $hours . 'h ';
        }

        if ($minutes > 0) {
            $formattedRuntime .= $minutes . 'm';
        }

        return trim($formattedRuntime);
    }
}
