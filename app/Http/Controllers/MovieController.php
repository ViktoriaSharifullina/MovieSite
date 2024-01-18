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
        $popular = $this->getPopularMovies();
        $upcoming = $this->getUpcomingMovies();

        $bannerMovie = $this->getBannerMovie($popular);
        $popularMovies = $this->getOtherMovies($popular);
        $upcomingMovies = $this->getOtherMovies($upcoming);

        return view('home', compact('bannerMovie', 'popularMovies', 'upcomingMovies'));
    }

    private function getPopularMovies()
    {
        $response = Http::get('https://api.themoviedb.org/3/discover/movie', [
            'api_key' => $this->api_key,
            'sort_by' => 'popularity.desc',
        ]);

        return array_slice($response->json()['results'], 0, 12);
    }

    public function getUpcomingMovies()
    {
        $response = Http::get('https://api.themoviedb.org/3/movie/upcoming', [
            'api_key' => $this->api_key
        ]);

        return array_slice($response->json()['results'], 0, 12);
    }

    public function getBannerMovie($movies)
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

    public function getOtherMovies($movies)
    {
        foreach ($movies as &$movie) {
            $movieDetails = $this->getMovieDetails($movie['id']);

            if ($movieDetails) {

                if ($movieDetails && isset($movieDetails['genres']) && count($movieDetails['genres']) > 0) {
                    $movie['primary_genre'] = $this->getGenresName($movieDetails['genres'])[0];
                } else {
                    $movie['primary_genre'] = "none";
                }

                // $movie['primary_genre'] = $this->getGenresName($movieDetails['genres'])[0];
                $movie['release_year'] = $this->getReleaseYear($movieDetails['release_date']);
            }
        }

        return $movies;
    }

    public function getMovieDetails(int $movieId)
    {
        $movieDetailsResponse = Http::get("https://api.themoviedb.org/3/movie/{$movieId}", [
            'api_key' => $this->api_key,
        ]);

        return $movieDetailsResponse->json();
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
