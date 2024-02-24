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

    public function searchPeople(string $query)
    {
        $response = Http::get('https://api.themoviedb.org/3/search/person', [
            'api_key' => config('services.tmdb.api_key'),
            'query'   => $query,
        ]);

        $results = $response->json()['results'] ?? [];

        if (is_array($results)) {
            usort($results, function ($a, $b) {
                return $b['popularity'] <=> $a['popularity'];
            });
        }

        return $results;
    }

    public function searchPeopleWithFlag(string $query)
    {
        $searchPerformed = !empty($query);
        $searchResults = [];

        if ($searchPerformed) {
            $searchResults = $this->searchPeople($query);
        }

        return [
            'searchPerformed' => $searchPerformed,
            'searchResults' => $searchResults
        ];
    }
}
