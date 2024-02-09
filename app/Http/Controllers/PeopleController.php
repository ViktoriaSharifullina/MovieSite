<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PeopleController extends Controller
{
    private $api_key;

    public function __construct()
    {
        $this->api_key = config('services.tmdb.api_key');
    }

    public function index(int $id)
    {
        $person = $this->getPersonInfo($id);
        $knownForMovies = $this->getKnownForMovies($id);

        // dd($knownForMovies);

        return view('people.about', compact('person', 'knownForMovies'));
    }

    private function getPersonInfo(int $id)
    {
        $response = Http::get("https://api.themoviedb.org/3/person/{$id}", [
            'api_key' => $this->api_key,
        ]);

        return $response->json();
    }

    private function getKnownForMovies(int $id)
    {
        $response = Http::get("https://api.themoviedb.org/3/person/{$id}/combined_credits", [
            'api_key' => $this->api_key,
        ]);
        $credits = $response->json();

        $knownForMovies = collect($credits['cast'])
            ->sortByDesc('vote_average')
            ->take(8)
            ->all();


        return   $knownForMovies;
    }
}
