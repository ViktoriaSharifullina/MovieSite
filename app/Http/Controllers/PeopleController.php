<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function search(Request $request)
    {
        $query = $request->query('query');
        $searchResults = [];

        $searchResults  = $this->peopleService->searchPeople($query);

        return view('people.catalog', compact('searchResults'));
    }

    public function showCatalog(Request $request)
    {
        $popularPeople = $this->peopleService->getPopularPeople();
        $query = $request->query('query', '');

        $searchData = $this->peopleService->searchPeopleWithFlag($query);

        return view('people.catalog', [
            'popularPeople' => $popularPeople,
            'searchResults' => $searchData['searchResults'],
            'searchPerformed' => $searchData['searchPerformed']
        ]);
    }
}
