<?php

namespace App\Services;

use Carbon\Carbon;
use App\Http\Contracts\MovieApiClientInterface;
use App\Http\Contracts\MovieServiceInterface;

class MovieService implements MovieServiceInterface
{
    private $movieApiClientInterface;

    public function __construct(MovieApiClientInterface $movieApiClientInterface)
    {
        $this->movieApiClientInterface = $movieApiClientInterface;
    }

    public function getMoviesData(): array
    {
        set_time_limit(0);

        $popular = $this->movieApiClientInterface->getMovies('popular');
        $upcoming = $this->movieApiClientInterface->getMovies('upcoming');
        $topRated = $this->movieApiClientInterface->getMovies('top_rated');

        $bannerMovie = $this->getBannerMovie($popular);

        $popularMovies = $this->prepareMovies($popular);
        $upcomingMovies = $this->prepareMovies($upcoming);
        $topRatedMovies = $this->prepareMovies($topRated);

        return compact('bannerMovie', 'popularMovies', 'upcomingMovies', 'topRatedMovies');
    }


    private function getBannerMovie($movies)
    {
        $random_id = array_rand($movies);
        $movie = $movies[$random_id];
        $movieDetails = $this->movieApiClientInterface->getMovieDetails($movie['id']);

        if ($movieDetails) {
            $movie['genre_names'] = $this->getGenresName($movieDetails['genres']);
            $movie['formatted_release_date'] = $this->getFormattedDate($movieDetails['release_date']);
            $movie['formatted_runtime'] = $this->getFormattedRuntime($movieDetails['runtime']);
        }

        return $movie;
    }

    public function prepareMovies($movies)
    {
        return collect($movies)->map(function ($movie) {
            $movieDetails = $this->movieApiClientInterface->getMovieDetails($movie['id']);

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

    private function getInfoMovie($id)
    {
        $movie = $this->movieApiClientInterface->getMovieDetails($id);
        $movie['genre_names'] = $this->getGenresName($movie['genres']);
        $movie['formatted_release_date'] = $this->getFormattedDate($movie['release_date']);
        $movie['formatted_runtime'] = $this->getFormattedRuntime($movie['runtime']);

        $directorInfo = $this->movieApiClientInterface->getDirectorInfo($id);
        $movie['director'] = $directorInfo ? $directorInfo['name'] : 'Unknown Director';

        $writerInfo = $this->movieApiClientInterface->getWriterInfo($id);
        $movie['writer'] = $writerInfo ? $writerInfo['name'] : 'Unknown Writer';

        return $movie;
    }

    public function getMainActors(int $movieId)
    {
        $movieCredits = $this->movieApiClientInterface->getMovieCredits($movieId);

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
            $actor['photo'] = $this->movieApiClientInterface->getActorPhoto($actor['id']);
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

        $movies = $this->movieApiClientInterface->getMovies($filter);
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

        $moviesData = $this->movieApiClientInterface->getMoviesFromApi($filteredParams, $page);
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
        $movies = $this->movieApiClientInterface->searchMovies($query);
        $preparedMovies = $this->prepareMovies($movies);

        return $preparedMovies;
    }
}
