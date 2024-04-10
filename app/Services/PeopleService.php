<?php

namespace App\Services;

use App\Services\PeopleApiClient;

class PeopleService
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
            ->where('media_type', 'movie')
            ->sortByDesc('popularity')
            ->take(5)
            ->all();

        $knownForTvShows = collect($credits['cast'])
            ->where('media_type', 'tv')
            ->sortByDesc('popularity')
            ->unique('id')
            ->take(5)
            ->all();

        $knownFor = array_merge($knownForMovies, $knownForTvShows);

        return $knownFor;
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
