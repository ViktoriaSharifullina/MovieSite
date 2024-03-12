<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Http\Contracts\PeopleApiClientInterface;

class PeopleApiClient implements PeopleApiClientInterface
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.tmdb.api_key');
    }

    private function performApiRequest(string $url, array $queryParams = []): array
    {
        try {
            $response = Http::get($url, array_merge(['api_key' => $this->apiKey], $queryParams));

            if (!$response->successful()) {
                Log::error('TMDB API request failed', [
                    'url' => $url,
                    'queryParams' => $queryParams,
                    'responseStatus' => $response->status(),
                    'response' => $response->body(),
                ]);
                throw new \Exception("Failed to fetch data from TMDB API. Status code: " . $response->status());
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Exception caught in PeopleApiClient', [
                'exceptionMessage' => $e->getMessage(),
                'exception' => $e
            ]);
            throw new \Exception("An error occurred while fetching data.");
        }
    }

    public function getPopularPeople(): array
    {
        return $this->performApiRequest("https://api.themoviedb.org/3/person/popular", [])['results'];
    }

    public function getPersonInfo(int $id): array
    {
        return $this->performApiRequest("https://api.themoviedb.org/3/person/{$id}", []);
    }

    public function getKnownForMovies(int $id): array
    {
        return $this->performApiRequest("https://api.themoviedb.org/3/person/{$id}/combined_credits", []);
    }

    public function searchPeople(string $query): array
    {
        return $this->performApiRequest('https://api.themoviedb.org/3/search/person', ['query' => $query])['results'];
    }
}
