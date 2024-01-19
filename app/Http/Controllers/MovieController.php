<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class MovieController extends Controller
{
    private $api_key;

    public function __construct()
    {
        $this->api_key = config('services.tmdb.api_key');
    }

    public function index()
    {
        set_time_limit(0);

        $popular = $this->getMovies('popular');
        $upcoming = $this->getMovies('upcoming');
        $topRated = $this->getMovies('top_rated');

        $bannerMovie = $this->getBannerMovie($popular);

        $popularMovies = $this->prepareMovies($popular);
        $upcomingMovies = $this->prepareMovies($upcoming);
        $topRatedMovies = $this->prepareMovies($topRated);

        return view('home', compact('bannerMovie', 'popularMovies', 'upcomingMovies', 'topRatedMovies'));
    }

    private function getMovies($type, $perPage = 10)
    {
        return cache()->remember("movies_{$type}", now()->addHours(1), function () use ($type, $perPage) {
            $response = Http::get("https://api.themoviedb.org/3/movie/{$type}", [
                'api_key' => $this->api_key,
                'page' => 1,
            ]);

            $results = $response->json()['results'];

            return array_slice($results, 0, $perPage);
        });
    }

    private function getBannerMovie($movies)
    {
        $random_id = array_rand($movies);
        $movie = $movies[$random_id];
        $movieDetails = $this->getMovieDetails($movie['id']);

        if ($movieDetails) {
            $movie['genre_names'] = $this->getGenresName($movieDetails['genres']);
            $movie['formatted_release_date'] = $this->getFormattedDate($movieDetails['release_date']);
            $movie['formatted_runtime'] = $this->getFormattedRuntime($movieDetails['runtime']);
        }

        return $movie;
    }

    public function prepareMovies($movies)
    {
        return collect($movies)->map(function ($movie) {
            $movieDetails = $this->getMovieDetails($movie['id']);

            if ($movieDetails) {
                $movie['primary_genre'] = $this->getGenresName($movieDetails['genres'])[0] ?? 'Unknown Genre';
                $movie['release_year'] = $this->getReleaseYear($movieDetails['release_date']) ?? 'Unknown Year';
            }

            return $movie;
        })->all();
    }

    private function getMovieDetails(int $movieId)
    {
        $movieDetailsResponse = Http::get("https://api.themoviedb.org/3/movie/{$movieId}", [
            'api_key' => $this->api_key,
        ]);

        return $movieDetailsResponse->json();
    }

    private function getGenresName(array $genreIds)
    {
        $genreNames = collect($genreIds)->pluck('name')->toArray();

        return $genreNames;
    }

    private function getFormattedDate($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    private function getReleaseYear($date)
    {
        return Carbon::parse($date)->format('Y');
    }

    private function getFormattedRuntime($runtime)
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
