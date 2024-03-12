<?php

namespace App\Http\Contracts;

interface PeopleServiceInterface
{
    public function getPopularPeople(): array;
    public function getPersonInfo(int $id): array;
    public function getKnownForMovies(int $id): array;
    public function searchPeople(string $query): array;
    public function searchPeopleWithFlag(string $query): array;
}
