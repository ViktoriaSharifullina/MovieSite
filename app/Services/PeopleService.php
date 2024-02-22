<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PeopleService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.tmdb.api_key');
    }

    public function getPopularPeople()
    {
        $response = Http::get("https://api.themoviedb.org/3/person/popular", [
            'api_key' => $this->apiKey,
        ]);

        return $response->json()['results'];
    }

    public function getPersonInfo(int $id)
    {
        $response = Http::get("https://api.themoviedb.org/3/person/{$id}", [
            'api_key' => $this->apiKey,
        ]);

        return $response->json();
    }

    public function getKnownForMovies(int $id)
    {
        $response = Http::get("https://api.themoviedb.org/3/person/{$id}/combined_credits", [
            'api_key' => $this->apiKey,
        ]);
        $credits = $response->json();

        $knownForMovies = collect($credits['cast'])
            ->sortByDesc('vote_average')
            ->take(8)
            ->all();


        return   $knownForMovies;
    }
}
