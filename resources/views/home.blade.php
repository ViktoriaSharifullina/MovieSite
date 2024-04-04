@extends('layouts/app')

@section('style')
@vite(['resources/css/home.css'])
@endsection

@section('content')
<div class="main-container">
    <div class="content-container">
        <div class="featured-img">
            <img src="{{ 'https://image.tmdb.org/t/p/original/' . $bannerMovie['backdrop_path'] }}" alt="{{ $bannerMovie['title'] }} Backdrop">
        </div>
        <div class="movie-details">
            <div class="title">{{ $bannerMovie['title'] }}</div>
            <ul class="facts">
                <li>
                    <div class="release-date">{{ $bannerMovie['formatted_release_date'] }}</div>
                </li>
                <li>
                    <div class="genres">{{ implode(', ', $bannerMovie['genre_names']) }}</div>
                </li>
                <li>
                    <div class="runtime">{{ $bannerMovie['formatted_runtime'] }}</div>
                </li>
            </ul>
            <div class="desc">{{ $bannerMovie['overview'] }}</div>
            <a class="feature-button btn" href="{{ route('movie.about', $bannerMovie['id']) }}">Read more</a>
        </div>
    </div>

    <div class="movie-list-container">
        <div class="movie-list-title title-popular">Popular</div>
        <div class="movie-list-wrapper">
            <div class="movie-list">
                @foreach ($popularMovies as $movie)
                <div class="movie-list-item">
                    <a href="{{ route('movie.about', $movie['id']) }}">
                        <div class="movie-poster">
                            <img src="https://image.tmdb.org/t/p/w154{{ $movie['poster_path'] }}" class="movie-poster">
                            <button class="bookmark-btn" title="Watch later">
                                <i class="fa fa-bookmark"></i>
                            </button>
                            <div class="rating {{ $movie['vote_average'] < 5 ? 'low' : ($movie['vote_average'] < 7 ? 'medium' : 'high') }}">
                                {{ number_format($movie['vote_average'], 1) }}
                            </div>
                        </div>
                    </a>
                    <div class="movie-facts">
                        <div class="movie-title">
                            {{ $movie['title'] }}
                        </div>
                        <span class="release-year">{{ $movie['release_year'] }}, </span>
                        <span class="primary-genre">{{ $movie['primary_genre'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="gradient"></div>
        </div>
        <a title="Next" class="arrow next"></a>
    </div>

    <div class="movie-list-container">
        <div class="movie-list-title">Upcoming</div>
        <div class="movie-list-wrapper">
            <div class="movie-list">
                @foreach ($upcomingMovies as $movie)
                <div class="movie-list-item">
                    <a href="{{ route('movie.about', $movie['id']) }}">
                        <div class="movie-poster">
                            <img src="https://image.tmdb.org/t/p/w342{{ $movie['poster_path'] }}" class="movie-poster">
                            <button class="bookmark-btn" title="Watch later">
                                <i class="fa fa-bookmark"></i>
                            </button>
                            <div class="rating {{ $movie['vote_average'] < 5 ? 'low' : ($movie['vote_average'] < 7 ? 'medium' : 'high') }}">
                                {{ number_format($movie['vote_average'], 1) }}
                            </div>
                        </div>
                    </a>
                    <div class="movie-facts">
                        <div class="movie-title">
                            {{ $movie['title'] }}
                        </div>
                        <span class="release-year">{{ $movie['release_year'] }}, </span>
                        <span class="primary-genre">{{ $movie['primary_genre'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="gradient"></div>
        </div>
        <a title="Next" class="arrow next"></a>
    </div>
</div>

<div class="movie-list-container">
    <div class="movie-list-title">Top Rated</div>
    <div class="movie-list-wrapper">
        <div class="movie-list">
            @foreach ($topRatedMovies as $movie)
            <div class="movie-list-item">
                <a href="{{ route('movie.about', $movie['id']) }}">
                    <div class="movie-poster">
                        <img src="https://image.tmdb.org/t/p/w342{{ $movie['poster_path'] }}" class="movie-poster">
                        <button class="bookmark-btn" title="Watch later">
                            <i class="fa fa-bookmark"></i>
                        </button>
                        <div class="rating {{ $movie['vote_average'] < 5 ? 'low' : ($movie['vote_average'] < 7 ? 'medium' : 'high') }}">
                            {{ number_format($movie['vote_average'], 1) }}
                        </div>
                    </div>
                </a>
                <div class="movie-facts">
                    <div class="movie-title">
                        {{ $movie['title'] }}
                    </div>
                    <span class="release-year">{{ $movie['release_year'] }}, </span>
                    <span class="primary-genre">{{ $movie['primary_genre'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
        <div class="gradient"></div>
    </div>
    <a title="Next" class="arrow next"></a>
</div>
@endsection

@section('script')
@vite(['resources/js/homepage.js'])
@endsection