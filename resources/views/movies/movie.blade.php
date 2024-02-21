@extends('layouts/app')

@section('style')
@vite(['resources/css/about-movie.css'])
@vite(['resources/css/slider-reviews.css'])
@vite(['resources/css/comments-section.css'])
@endsection

@section('content')

<div class="content-container">
    <div class="featured-img">
        @if ($movie['backdrop_path'])
        <img src="{{ 'https://image.tmdb.org/t/p/original/' . $movie['backdrop_path'] }}" alt="{{ $movie['title'] }} Backdrop">
        @endif
    </div>
    <div class="movie-details">
        <div class="movie-poster">
            <img class="movie-poster" src="{{ 'https://image.tmdb.org/t/p/original/' . $movie['poster_path'] }}" alt="{{ $movie['title'] }} Poster">
        </div>
        <div class="movie-info">
            <div class="title">{{ $movie['title'] }}</div>
            <ul class="facts">
                @if ($movie['formatted_release_date'])
                <li>
                    <div class="release-date">{{ $movie['formatted_release_date'] }}</div>
                </li>
                @endif
                @if ($movie['genres'])
                <li>
                    <div class="genres">{{ implode(', ', $movie['genre_names']) }}</div>
                </li>
                @endif
                @if ($movie['formatted_runtime'])
                <li>
                    <div class="runtime">{{ $movie['formatted_runtime'] }}</div>
                </li>
                @endif
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
            <div class="desc">
                <div class="tagline"><i>{{ $movie['tagline'] }}</i></div>
                <div class="overview">Overview</div>
                {{ $movie['overview'] }}
            </div>
            <div class="director-container">
                <div class="director-info">
                    {{ $movie['director'] }}
                </div>
                <div class="director">
                    Director
                </div>
            </div>
            <div class="writer-container">
                <div class="writer-info">
                    <div class="writer-info">
                        {{ $movie['writer'] }}
                    </div>
                    <div class="writer">
                        Screenplay
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="text-container">
    <div class="main-roles-container">
        <div class="main-roles-container-name">Starring</div>
        <div class="main-roles">
            @foreach ($mainActors as $actor)
            <a class="card card-actor" href="{{ route('people.about', $actor['id']) }}">
                @if(isset($actor['photo']))
                <img class="card-img-actor" src="{{ 'https://image.tmdb.org/t/p/w500' . $actor['photo'] }}" alt="Card image cap">
                @else
                <div class="no-image-overlay" style="height: 160px;">
                    <span class="no-image-placeholder">No Image</span>
                </div>
                @endif
                <div class="card-body actor-card-body">
                    <div class="card-title">{{ $actor['name'] }}</div>
                    <div class="card-text">{{ $actor['character'] }}</div>
                </div>
            </a>
            @endforeach
        </div>
        <div class="gradient"></div>
    </div>
    <div class="more-movie-details">
        <div class="the-original-title">The original title
            <div class="original-title-value">{{ $movie['original_title'] }}</div>
        </div>
        <div class="status">Status
            <div class="status-value">{{ $movie['status'] }}</div>
        </div>
        <div class="the-original-language">The original language
            <div class="language-value">{{ $movie['original_language'] }}</div>
        </div>
        <div class="budget">Budget
            <div class="budget-value">{{'$' . number_format($movie['budget'], 2, '.', ',')}}</div>
        </div>
        <div class="revenue">Revenue
            <div class="revenue-value">{{'$' . number_format($movie['revenue'], 2, '.', ',')}}</div>
        </div>
    </div>
</div>

<div class="social-media-container">
    <div class="social-menu">
        <div class="reviews active">
            Reviews
        </div>
        <div class="discussions">
            Discussions
        </div>
    </div>
    <div class="social-menu-container">
        @include('layouts/slider-reviews')
        <div class="gradient-menu-right"></div> -->
        <div class="gradient-menu-left"></div>
        <a title="Previous" class="arrow prev"></a>
        <a title="Next" class="arrow next"></a>
        <div class="swiper-pagination"></div>
    </div>
    <div class="comments-container">
        @include('layouts/comments-section')
    </div>
</div>




@endsection

@section('script')
<script src="//cdn.jsdelivr.net/gh/freeps2/a7rarpress@main/swiper-bundle.min.js"></script>
@vite(['resources/js/movie.js'])
@vite(['resources/js/comments-section.js'])
@endsection