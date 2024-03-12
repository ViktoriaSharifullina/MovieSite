<?php

namespace App\Http\Contracts;

interface MovieApiServiceInterface
{
    public function getMovies(string $type): array;
    public function getMovieDetails(int $movieId): array;
    public function getMovieCredits(int $movieId): array;
    public function getActorDetails(int $actorId): array;
    public function getDirectorInfo(int $movieId): array;
    public function getWriterInfo(int $movieId): array;
    public function getActorPhoto(int $actorId): string;
    public function getMoviesSorted(string $type, string $sort, int $page = 1): array;
    public function getMoviesFromApi(array $filterParams, int $page = 1): array;
}
