<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TvController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WatchlistController;

Route::get('/', [MovieController::class, 'index'])->name('home');
Route::get('/movie/{id}', [MovieController::class, 'aboutMovie'])->name('movie.about');

Route::get('/tv/{id}', [TvController::class, 'aboutTv'])->name('tv.about');

Route::get('/series-catalog/basic', [TvController::class, 'catalogBasic'])->name('tv.catalogBasic');
Route::get('/series-catalog/advanced', [TvController::class, 'catalogAdvanced'])->name('tv.catalogAdvanced');
Route::get('/series-catalog/search', [TvController::class, 'search'])->name('tv.search');

Route::get('/movie-catalog/basic', [MovieController::class, 'catalogBasic'])->name('movie.catalogBasic');
Route::get('/movie-catalog/advanced', [MovieController::class, 'catalogAdvanced'])->name('movie.catalogAdvanced');
Route::get('/movie-catalog/search', [MovieController::class, 'search'])->name('movies.search');

Route::get('/people-catalog', [PeopleController::class, 'showCatalog'])->name('people.catalog');
Route::get('/people/{id}', [PeopleController::class, 'index'])->name('people.about');

Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/users', [UserController::class, 'show'])->name('users');
Route::get('/profile/{userId}', [UserController::class, 'showProfile'])->name('user.profile');
Route::post('/add-friend/{userId}', [FollowController::class, 'toggleFriend'])->name('toggle.friend');


Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::get('/profile/info', [UserController::class, 'editProfile'])->name('profile.info');
    Route::put('/user/update', [UserController::class, 'updateUser'])->name('user.update');

    Route::get('/profile/list/{listType}', [MovieController::class, 'showList'])->name('profile.list');
    Route::get('/profile/movies', [MovieController::class, 'showMovies'])->name('profile.movies');

    Route::post('/watchlist/toggle', [WatchlistController::class, 'toggle'])->name('watchlist.toggle');
    Route::post('/rating/toggle', [RatingController::class, 'toggle'])->name('rating.toggle');

    Route::post('/review/create', [ReviewController::class, 'store'])->name('review.store');
});
