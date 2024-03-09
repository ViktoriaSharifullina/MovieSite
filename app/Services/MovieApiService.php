<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MovieApiService
{
    private $api_key;

    public function __construct()
    {
        $this->api_key = config('services.tmdb.api_key');
    }

    public function getApiKey()
    {
        return $this->api_key;
    }

    public function getMovies($type)
    {
        return cache()->remember("movies_{$type}", now()->addHours(1), function () use ($type) {
            $response = Http::get("https://api.themoviedb.org/3/movie/{$type}", [
                'api_key' => $this->api_key,
                'page' => 1,
            ]);

            $data = $response->json();
            $results = $data['results'];

            return $results;
        });
    }

    public function getMovieDetails($movieId)
    {
        $movieDetailsResponse = Http::get("https://api.themoviedb.org/3/movie/{$movieId}", [
            'api_key' => $this->api_key,
        ]);

        return $movieDetailsResponse->json();
    }

    public function getMovieCredits($movieId)
    {
        $movieCreditsResponse = Http::get("https://api.themoviedb.org/3/movie/{$movieId}/credits", [
            'api_key' => $this->api_key,
        ]);

        return $movieCreditsResponse->json();
    }

    public function getActorDetails($actorId)
    {
        $response = Http::get("https://api.themoviedb.org/3/person/{$actorId}", [
            'api_key' => $this->api_key,
        ]);

        return $response->json();
    }

    public function getDirectorInfo(int $movieId)
    {
        $creditsResponse = Http::get("https://api.themoviedb.org/3/movie/{$movieId}/credits", [
            'api_key' => $this->api_key,
        ]);

        $directorInfo = $creditsResponse->json()['crew'];

        return collect($directorInfo)->firstWhere('job', 'Director');
    }

    public function getWriterInfo(int $movieId)
    {
        $creditsResponse = Http::get("https://api.themoviedb.org/3/movie/{$movieId}/credits", [
            'api_key' => $this->api_key,
        ]);

        $writerInfo = $creditsResponse->json()['crew'];

        return collect($writerInfo)->firstWhere('job', 'Screenplay');
    }

    public function getActorPhoto(int $actorId)
    {
        $response = Http::get("https://api.themoviedb.org/3/person/{$actorId}", [
            'api_key' => $this->api_key,
        ]);

        $actorDetails = $response->json();

        return $actorDetails['profile_path'];
    }

    public function getMoviesSorted($type, $sort, $page = 1)
    {
        $queryParams = [
            'api_key' => $this->api_key,
            'page' => $page,
            'sort_by' => $sort,
        ];

        $response = Http::get("https://api.themoviedb.org/3/movie/{$type}", $queryParams);

        return $response->json();
    }

    public function getMoviesFromApi($filterParams, $page = 1)
    {
        $queryParams = array_merge([
            'api_key' => $this->api_key,
            'page' => $page,
        ], $filterParams);

        // dd($filterParams);

        $response = Http::get("https://api.themoviedb.org/3/discover/movie", $queryParams);

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception("Error fetching movies from TMDB API: " . $response->body());
        }
    }
}
