@extends('layouts/app')

@section('style')
@vite(['resources/css/about-movie.css'])
@endsection

@section('content')

<div class="content-container">
    <div class="featured-img">
        <img src="{{ 'https://image.tmdb.org/t/p/original/' . $movie['backdrop_path'] }}" alt="{{ $movie['title'] }} Backdrop">
    </div>
    <div class="movie-details">
        <div class="movie-poster">
            <img class="movie-poster" src="{{ 'https://image.tmdb.org/t/p/original/' . $movie['poster_path'] }}" alt="{{ $movie['title'] }} Poster">
        </div>
        <div class="movie-info">
            <div class="title">{{ $movie['title'] }}</div>
            <ul class="facts">
                <li>
                    <div class="release-date">{{ $movie['formatted_release_date'] }}</div>
                </li>
                <li>
                    <div class="genres">{{ implode(', ', $movie['genre_names']) }}</div>
                </li>
                <li>
                    <div class="runtime">{{ $movie['formatted_runtime'] }}</div>
                </li>
            </ul>
            <div class="horizontal-menu">
                <div class="rating {{ $movie['vote_average'] < 5 ? 'low' : ($movie['vote_average'] < 7 ? 'medium' : 'high') }}">
                    {{ number_format($movie['vote_average'], 1) }}
                </div>
                <div class="buttons-container" id="buttons-container">
                    <button class="btn bookmark-btn" title="Watch later">
                        <i class="fa fa-bookmark"></i>
                    </button>
                    <button class="btn another-btn" title="Another Button">
                        <i class="fa fa-heart"></i>
                    </button>
                    <button class="btn another-btn" title="Another Button">
                        <i class="fa fa-star"></i>
                    </button>
                </div>
            </div>
            <div class="desc">{{ $movie['overview'] }}</div>
        </div>
    </div>
</div>



@endsection

@section('script')
@vite(['resources/js/movie.js'])
@endsection