<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\WatchlistController;

Route::get('/', [MovieController::class, 'index'])->name('home');
Route::get('/movie/{id}', [MovieController::class, 'aboutMovie'])->name('movie.about');

Route::get('/movie-catalog/basic', [MovieController::class, 'catalogBasic'])->name('movie.catalogBasic');
Route::get('/movie-catalog/advanced', [MovieController::class, 'catalogAdvanced'])->name('movie.catalogAdvanced');
Route::get('/movie-catalog/search', [MovieController::class, 'search'])->name('movies.search');


Route::get('/series-catalog', function () {
    return view('/series/series-catalog');
});

Route::get('/people-catalog', [PeopleController::class, 'showCatalog'])->name('people.catalog');
Route::get('/people/{id}', [PeopleController::class, 'index'])->name('people.about');

Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::get('/change-info', function () {
        return view('/profile/change-info');
    })->name('change-info');
    Route::post('/watchlist/toggle', [WatchlistController::class, 'toggle'])->name('watchlist.toggle');
    Route::post('/rating/toggle', [RatingController::class, 'toggle'])->name('rating.toggle');
});
