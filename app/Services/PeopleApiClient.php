<?php

namespace App\Services;

use App\Http\Contracts\PeopleApiClientInterface;
use Illuminate\Support\Facades\Http;

class PeopleApiClient implements PeopleApiClientInterface
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.tmdb.api_key');
    }

    public function getPopularPeople(): array
    {
        $response = Http::get("https://api.themoviedb.org/3/person/popular", [
            'api_key' => $this->apiKey,
        ]);

        return $response->json()['results'];
    }

    public function getPersonInfo(int $id): array
    {
        $response = Http::get("https://api.themoviedb.org/3/person/{$id}", [
            'api_key' => $this->apiKey,
        ]);

        return $response->json();
    }

    public function getKnownForMovies(int $id): array
    {
        $response = Http::get("https://api.themoviedb.org/3/person/{$id}/combined_credits", [
            'api_key' => $this->apiKey,
        ]);

        return $response->json();
    }

    public function searchPeople(string $query): array
    {
        $response = Http::get('https://api.themoviedb.org/3/search/person', [
            'api_key' => $this->apiKey,
            'query' => $query,
        ]);

        return $response->json()['results'] ?? [];
    }
}
