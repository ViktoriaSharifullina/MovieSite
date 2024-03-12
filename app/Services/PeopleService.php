<?php

namespace App\Services;

use App\Services\PeopleApiClient;
use App\Http\Contracts\PeopleServiceInterface;

class PeopleService implements PeopleServiceInterface
{
    protected $apiClient;

    public function __construct(PeopleApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function getPopularPeople(): array
    {
        return $this->apiClient->getPopularPeople();
    }

    public function getPersonInfo(int $id): array
    {
        return $this->apiClient->getPersonInfo($id);
    }

    public function getKnownForMovies(int $id): array
    {
        $credits = $this->apiClient->getKnownForMovies($id);

        $knownForMovies = collect($credits['cast'])
            ->sortByDesc('vote_average')
            ->take(8)
            ->all();

        return $knownForMovies;
    }

    public function searchPeople(string $query): array
    {
        $results = $this->apiClient->searchPeople($query);

        if (is_array($results)) {
            usort($results, function ($a, $b) {
                return $b['popularity'] <=> $a['popularity'];
            });
        }

        return $results;
    }

    public function searchPeopleWithFlag(string $query): array
    {
        $searchPerformed = !empty($query);
        $searchResults = $searchPerformed ? $this->searchPeople($query) : [];

        return [
            'searchPerformed' => $searchPerformed,
            'searchResults' => $searchResults
        ];
    }
}
