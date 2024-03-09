<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PeopleController;

Route::get('/', [MovieController::class, 'index'])->name('home');
Route::get('/movie/{id}', [MovieController::class, 'aboutMovie'])->name('movie.about');

Route::get('/movie-catalog/basic', [MovieController::class, 'catalogBasic'])->name('movie.catalogBasic');
Route::get('/movie-catalog/advanced', [MovieController::class, 'catalogAdvanced'])->name('movie.catalogAdvanced');

Route::get('/series-catalog', function () {
    return view('/series/series-catalog');
});

Route::get('/people-catalog', [PeopleController::class, 'showCatalog'])->name('people.catalog');
Route::get('/people/{id}', [PeopleController::class, 'index'])->name('people.about');

Route::get('/profile', function () {
    return view('/profile');
});
