<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('home');
// });

Route::get('/', [MovieController::class, 'index']);
Route::get('/movie-catalog', function () {
    return view('/movies/movie-catalog');
});
Route::get('/series-catalog', function () {
    return view('/series/series-catalog');
});
Route::get('/people', function () {
    return view('people');
});
Route::get('/profile', function () {
    return view('/profile');
});
