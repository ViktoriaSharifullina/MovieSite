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
                <div class="rating-number {{ $movie['vote_average'] < 5 ? 'low' : ($movie['vote_average'] < 7 ? 'medium' : 'high') }}">
                    {{ number_format($movie['vote_average'], 1) }}
                </div>
                <div class="buttons-container" id="buttons-container">
                    <button class="btn bookmark-btn" title="Watch later">
                        <div class="btn-content">
                            <i class="fa fa-bookmark"></i>
                        </div>
                    </button>
                    <button class="btn heart-btn">
                        <div class="btn-content">
                            <i class="fa fa-heart"></i>
                        </div>
                    </button>
                    <button id="starButton" class="btn star-btn">
                        <div class="btn-content" id="btn-star-content">
                            <div class="btn-star-text hidden" id="btn-star-text">Delete the raiting</div>
                            <i class="fa fa-star" id="iconStar">
                                <span id="selectedNumber" class="hidden"></span>
                            </i>
                        </div>
                    </button>
                    <div class="rating hidden" id="ratingMenu">
                        <div class="star-icon">
                            <i class="fa fa-star" id="iconStarMenu"></i>
                        </div>
                        <div class="rating-numbers">
                            <span class="number-rate">1</span>
                            <span class="number-rate">2</span>
                            <span class="number-rate">3</span>
                            <span class="number-rate">4</span>
                            <span class="number-rate">5</span>
                            <span class="number-rate">6</span>
                            <span class="number-rate">7</span>
                            <span class="number-rate">8</span>
                            <span class="number-rate">9</span>
                            <span class="number-rate">10</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="desc">{{ $movie['overview'] }}</div>
        </div>
    </div>
</div>
<div class="text-container">

</div>



@endsection

@section('script')

@vite(['resources/js/movie.js'])
@endsection