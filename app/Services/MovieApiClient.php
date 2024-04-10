<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class MovieApiClient
{
    private $api_key;
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->api_key = config('services.tmdb.api_key');
    }

    public function getApiKey()
    {
        return $this->api_key;
    }

    private function performApiRequest(string $url, array $params = []): array
    {
        try {
            $response = Http::get($url, $params + ['api_key' => $this->api_key]);

            if (!$response->successful()) {
                Log::error('TMDB API request failed', [
                    'url' => $url,
                    'params' => $params,
                    'responseStatus' => $response->status(),
                    'response' => $response->body(),
                ]);
                throw new \Exception("Failed to fetch data from TMDB API. Status code: " . $response->status());
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Exception caught during API request', [
                'url' => $url,
                'params' => $params,
                'exceptionMessage' => $e->getMessage(),
                'exception' => $e,
            ]);
            throw new \Exception("An error occurred while fetching data from TMDB API.");
        }
    }

    public function getContentByFilter($type): array
    {
        $results = cache()->remember("movies_{$type}", now()->addHours(1), function () use ($type) {
            return $this->performApiRequest("https://api.themoviedb.org/3/movie/{$type}", ['page' => 1])['results'];
        });

        return $results;
    }

    public function getContentDetails($contentId, $contentType = 'movie'): array
    {
        return $this->performApiRequest("https://api.themoviedb.org/3/{$contentType}/{$contentId}");
    }

    public function getContentCredits($contentId, $contentType = 'movie'): array
    {
        return $this->performApiRequest("https://api.themoviedb.org/3/{$contentType}/{$contentId}/credits");
    }

    public function getActorDetails($actorId): array
    {
        return $this->performApiRequest("https://api.themoviedb.org/3/person/{$actorId}", []);
    }

    public function getDirectorInfo(int $contentId, $contentType = 'movie'): array
    {
        $creditsResponse = $this->performApiRequest("https://api.themoviedb.org/3/{$contentType}/{$contentId}/credits", []);
        $directorInfo = collect($creditsResponse['crew'])->firstWhere('job', 'Director');
        return $directorInfo ?: [];
    }

    public function getWriterInfo(int $contentId, $contentType = 'movie'): array
    {
        $creditsResponse = $this->performApiRequest("https://api.themoviedb.org/3/{$contentType}/{$contentId}/credits", []);
        $writerInfo = collect($creditsResponse['crew'])->firstWhere('job', 'Screenplay');
        return $writerInfo ?: [];
    }

    public function getActorPhoto(int $actorId): string
    {
        $actorDetails = $this->performApiRequest("https://api.themoviedb.org/3/person/{$actorId}", []);

        return $actorDetails['profile_path'] ?: [];
    }

    public function getContentSorted($type, $sort, $page = 1, $contentType = 'movie'): array
    {
        $queryParams = [
            'page' => $page,
            'sort_by' => $sort,
        ];

        return $this->performApiRequest("https://api.themoviedb.org/3/{$contentType}/{$type}", $queryParams);
    }

    public function getContentFromApi($filterParams, $page = 1, $contentType = 'movie'): array
    {
        $queryParams = array_merge([
            'api_key' => $this->api_key,
            'page' => $page,
        ], $filterParams);

        return $this->performApiRequest("https://api.themoviedb.org/3/discover/{$contentType}", $queryParams);
    }

    public function searchContent(string $query, $contentType = 'movie'): array
    {
        return $this->performApiRequest("https://api.themoviedb.org/3/search/{$contentType}", ['query' => $query])['results'];
    }
}
