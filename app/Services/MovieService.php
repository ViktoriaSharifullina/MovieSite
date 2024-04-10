<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Rating;
use GuzzleHttp\Client;
use App\Services\MovieApiClient;

class MovieService
{
    private $movieApiClient;

    public function __construct(MovieApiClient $movieApiClient)
    {
        $this->movieApiClient = $movieApiClient;
    }

    public function getContentData($contentType = 'movie'): array
    {
        set_time_limit(0);

        $popularContent = $this->movieApiClient->getContentByFilter('popular', $contentType);
        $upcomingContent = $this->movieApiClient->getContentByFilter('upcoming', $contentType);
        $topRatedContent = $this->movieApiClient->getContentByFilter('top_rated', $contentType);

        $bannerMovie = $this->getBanner($popularContent);

        $pContent = $this->prepareMovies($popularContent);
        $upContent = $this->prepareMovies($upcomingContent);
        $topContent = $this->prepareMovies($topRatedContent);

        $result = compact('bannerMovie', 'pContent', 'upContent', 'topContent');
        return [
            'bannerMovie' => $result['bannerMovie'],
            'popularMovies' => $result['pContent'],
            'upcomingMovies' => $result['upContent'],
            'topRatedMovies' => $result['topContent'],
        ];
    }


    private function getBanner($content)
    {
        $random_id = array_rand($content);
        $media = $content[$random_id];
        $contentDetails = $this->movieApiClient->getContentDetails($media['id']);

        if ($contentDetails) {
            $media['genre_names'] = $this->getGenresName($contentDetails['genres']);
            $media['formatted_release_date'] = $this->getFormattedDate($contentDetails['release_date']);
            $media['formatted_runtime'] = $this->getFormattedRuntime($contentDetails['runtime']);
        }

        return $media;
    }

    public function prepareMovies($movies)
    {
        return collect($movies)->map(function ($movie) {
            $movieDetails = $this->movieApiClient->getContentDetails($movie['id']);

            if ($movieDetails) {
                $movie['primary_genre'] = $this->getGenresName($movieDetails['genres'])[0] ?? 'Unknown Genre';
                $movie['release_year'] = $this->getReleaseYear($movieDetails['release_date']) ?? 'Unknown Year';
            }

            return $movie;
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

    public function getInfoMovie($id)
    {
        $movie = $this->movieApiClient->getContentDetails($id);
        $movie['genre_names'] = $this->getGenresName($movie['genres']);
        $movie['formatted_release_date'] = $this->getFormattedDate($movie['release_date']);
        $movie['formatted_runtime'] = $this->getFormattedRuntime($movie['runtime']);

        $directorInfo = $this->movieApiClient->getDirectorInfo($id);
        $movie['director'] = $directorInfo ? $directorInfo['name'] : 'Unknown Director';

        $writerInfo = $this->movieApiClient->getWriterInfo($id);
        $movie['writer'] = $writerInfo ? $writerInfo['name'] : 'Unknown Writer';

        $movie['media_type'] = 'movie';

        return $movie;
    }

    public function getMainActors(int $movieId)
    {
        $movieCredits = $this->movieApiClient->getContentCredits($movieId);

        $mainActors = collect($movieCredits['cast'])
            ->where('order', '<=', 10)
            ->map(function ($actor) {
                return [
                    'id' => $actor['id'],
                    'name' => $actor['name'],
                    'character' => $actor['character'],
                ];
            });

        $actorsWithImages = collect($mainActors)->map(function ($actor) {
            $actor['photo'] = $this->movieApiClient->getActorPhoto($actor['id']);
            return $actor;
        });

        return $actorsWithImages;
    }


    public function aboutMovie(int $id)
    {
        $movie = $this->getInfoMovie($id);
        $mainActors = $this->getMainActors($id);

        return view('movies/movie', compact('movie', 'mainActors'));
    }

    public function getMovieDetailsAndActors(int $movieId): array
    {
        $movie = $this->getInfoMovie($movieId);
        $mainActors = $this->getMainActors($movieId);

        return compact('movie', 'mainActors');
    }

    public function getMoviesByFilter($filter): array
    {
        if (!in_array($filter, ['popular', 'upcoming', 'top_rated'])) {
            $filter = 'popular';
        }

        $movies = $this->movieApiClient->getContentByFilter($filter);
        $preparedMovies = $this->prepareMovies($movies);

        return $preparedMovies;
    }

    public function filterNonEmptyParams($params)
    {
        return array_filter($params, function ($value) {
            return !empty($value);
        });
    }

    public function getMoviesFilteredAndSorted(array $filterParams, int $page = 1): array
    {
        $filteredParams = $this->filterNonEmptyParams($filterParams);

        $moviesData = $this->movieApiClient->getContentFromApi($filteredParams, $page);
        $preparedMovies = $this->prepareMovies($moviesData['results']);

        return [
            'movies' => $preparedMovies,
            'current_page' => $page,
            'total_pages' => $moviesData['total_pages'],
            'total_results' => $moviesData['total_results'],
        ];
    }

    public function searchMovies(string $query): array
    {
        $movies = $this->movieApiClient->searchContent($query);
        $preparedMovies = $this->prepareMovies($movies);

        return $preparedMovies;
    }

    public function getUserMoviesWithRatings($userId)
    {
        $ratings = Rating::where('user_id', $userId)
            ->where('media_type', 'movie')
            ->orderByDesc('created_at')
            ->get(['movie_tmdb_id', 'rating_value']);

        $moviesWithRatings = [];
        foreach ($ratings as $rating) {
            $movieInfo = $this->getInfoMovie($rating->movie_tmdb_id);
            $movieInfo['user_rating'] = $rating->rating_value;

            if (!in_array($movieInfo, $moviesWithRatings)) {
                $moviesWithRatings[] = $movieInfo;
            }
        }

        return $moviesWithRatings;
    }
}
