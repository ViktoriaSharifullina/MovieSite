<?php

namespace App\Http\Controllers;

use App\Services\PeopleService;

class PeopleController extends Controller
{
    protected $peopleService;

    public function __construct(PeopleService $peopleService)
    {
        $this->peopleService = $peopleService;
    }

    public function index(int $id)
    {
        $person = $this->peopleService->getPersonInfo($id);
        $knownForMovies = $this->peopleService->getKnownForMovies($id);

        return view('people.about', compact('person', 'knownForMovies'));
    }

    public function getPopularPeople()
    {
        $popularPeople = $this->peopleService->getPopularPeople();

        return view('people.catalog', compact('popularPeople'));
    }
}
