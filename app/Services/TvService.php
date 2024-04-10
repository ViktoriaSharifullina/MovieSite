<?php

namespace App\Services;

use Carbon\Carbon;
use App\Services\TvApiClient;

class TvService
{
    private $tvApiClient;

    public function __construct(TvApiClient $tvApiClient)
    {
        $this->tvApiClient = $tvApiClient;
    }

    public function getContentData(): array
    {
        set_time_limit(0);

        $popularContent = $this->tvApiClient->getContentByFilter('popular');
        $upcomingContent = $this->tvApiClient->getContentByFilter('upcoming');
        $topRatedContent = $this->tvApiClient->getContentByFilter('top_rated');

        $banner = $this->getBanner($popularContent);

        $pContent = $this->prepareTv($popularContent);
        $upContent = $this->prepareTv($upcomingContent);
        $topContent = $this->prepareTv($topRatedContent);

        return [
            'bannerTv' => $banner,
            'popularTv' => $pContent,
            'upcomingTv' => $upContent,
            'topRatedTv' => $topContent,
        ];
    }


    private function getBanner($content)
    {
        $random_id = array_rand($content);
        $media = $content[$random_id];
        $contentDetails = $this->tvApiClient->getContentDetails($media['id']);

        if ($contentDetails) {
            $media['genre_names'] = $this->getGenresName($contentDetails['genres']);
            $media['formatted_release_date'] = $this->getFormattedDate($contentDetails['release_date']);
            // $media['formatted_runtime'] = $this->getFormattedRuntime($contentDetails['runtime']);
        }

        return $media;
    }

    public function prepareTv($tvs)
    {
        return collect($tvs)->map(function ($tv) {
            $tvDetails = $this->tvApiClient->getContentDetails($tv['id']);

            if ($tvDetails) {
                $tv['primary_genre'] = $this->getGenresName($tvDetails['genres'])[0] ?? 'Unknown Genre';
                // $tv['release_year'] = $this->getReleaseYear($tvDetails['release_date']) ?? 'Unknown Year';
            }

            return $tv;
        })->all();
    }

    private function getGenresName(array $genreIds)
    {
        $genreNames = collect($genreIds)->pluck('name')->toArray();

        return $genreNames;
    }

    private function getFormattedDate($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    private function getReleaseYear($date)
    {
        return Carbon::parse($date)->format('Y');
    }

    private function getFormattedRuntime($runtime)
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

    public function getInfoTv($id)
    {
        $tv = $this->tvApiClient->getContentDetails($id);
        $tv['genre_names'] = $this->getGenresName($tv['genres']);

        $creators = collect($tv['created_by'])->map(function ($creator) {
            return [
                'name' => $creator['name'],
                'id' => $creator['id'],
                'profile_path' => $creator['profile_path'],
            ];
        });

        $tv['creators'] = $creators->all();
        $tv['media_type'] = 'tv';

        return $tv;
    }

    public function getMainActors(int $tvId)
    {
        $tvCredits = $this->tvApiClient->getContentCredits($tvId);

        $mainActors = collect($tvCredits['cast'])
            ->where('order', '<=', 10)
            ->map(function ($actor) {
                return [
                    'id' => $actor['id'],
                    'name' => $actor['name'],
                    'character' => $actor['character'],
                ];
            });

        $actorsWithImages = collect($mainActors)->map(function ($actor) {
            $actor['photo'] = $this->tvApiClient->getActorPhoto($actor['id']);
            return $actor;
        });

        return $actorsWithImages;
    }


    public function aboutTv(int $id)
    {
        $tv = $this->getInfoTv($id);
        $mainActors = $this->getMainActors($id);

        return view('tv/tv', compact('tv', 'mainActors'));
    }

    public function getTvDetailsAndActors(int $tvId): array
    {
        $tv = $this->getInfoTv($tvId);
        $mainActors = $this->getMainActors($tvId);

        return compact('tv', 'mainActors');
    }

    public function getTvByFilter($filter): array
    {
        if (!in_array($filter, ['popular', 'upcoming', 'top_rated'])) {
            $filter = 'popular';
        }

        $tv = $this->tvApiClient->getContentByFilter($filter);
        $preparedTv = $this->prepareTv($tv);

        return $preparedTv;
    }

    public function filterNonEmptyParams($params)
    {
        return array_filter($params, function ($value) {
            return !empty($value);
        });
    }

    public function getTvFilteredAndSorted(array $filterParams, int $page = 1): array
    {
        $filteredParams = $this->filterNonEmptyParams($filterParams);

        $tvData = $this->tvApiClient->getContentFromApi($filteredParams, $page);
        $preparedTv = $this->prepareTv($tvData['results']);

        return [
            'tv' => $preparedTv,
            'current_page' => $page,
            'total_pages' => $tvData['total_pages'],
            'total_results' => $tvData['total_results'],
        ];
    }

    public function searchTv(string $query): array
    {
        $tv = $this->tvApiClient->searchContent($query);
        $preparedTv = $this->prepareTv($tv);

        return $preparedTv;
    }
}
