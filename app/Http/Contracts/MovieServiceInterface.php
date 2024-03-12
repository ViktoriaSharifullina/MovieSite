<?php

namespace App\Http\Contracts;


interface MovieServiceInterface
{
    /**
     * Получить данные для главной страницы.
     *
     * @return array
     */
    public function getMoviesData(): array;

    /**
     * Получить детали фильма и актерский состав по ID фильма.
     *
     * @param int $movieId
     * @return array
     */
    public function getMovieDetailsAndActors(int $movieId): array;

    /**
     * Получить фильмы по заданному фильтру.
     *
     * @param string $filter
     * @return array
     */
    public function getMoviesByFilter(string $filter): array;

    /**
     * Получить фильтрованные и отсортированные фильмы на основе параметров запроса.
     *
     * @param array $filterParams
     * @return array
     */
    public function getMoviesFilteredAndSorted(array $filterParams): array;
}
