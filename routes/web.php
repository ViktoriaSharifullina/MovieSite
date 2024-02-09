<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PeopleController;

Route::get('/', [MovieController::class, 'index'])->name('home');
Route::get('/movie/{id}', [MovieController::class, 'aboutMovie'])->name('movie.about');

Route::get('/movie-catalog', function () {
    return view('/movies/movie-catalog');
});
Route::get('/series-catalog', function () {
    return view('/series/series-catalog');
});

Route::get('/people-catalog', function () {
    return view('people/catalog');
});
Route::get('/people/{id}', [PeopleController::class, 'index'])->name('people.about');

Route::get('/profile', function () {
    return view('/profile');
});
