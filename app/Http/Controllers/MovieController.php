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
        $otherMovies = array_slice($movies, 1);

        return view('home', compact('featuredMovie', 'otherMovies'));
    }

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
