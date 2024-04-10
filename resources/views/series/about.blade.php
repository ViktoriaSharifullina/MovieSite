@extends('layouts/app')

@section('style')
@vite(['resources/css/movie/about-movie.css'])
@vite(['resources/css/movie/slider-reviews.css'])
@vite(['resources/css/movie/comments-section.css'])
@endsection

@section('content')

<body data-user-authenticated="{{ Auth::check() }}">
    <div class="content-container">
        <div class="featured-img">
            @if ($tv['backdrop_path'])
            <img src="{{ 'https://image.tmdb.org/t/p/original/' . $tv['backdrop_path'] }}">
            @endif
        </div>
        <div class="movie-details">
            <div class="movie-poster">
                <img class="movie-poster" src="{{ 'https://image.tmdb.org/t/p/original/' . $tv['poster_path'] }}">
            </div>
            <div class="movie-info">
                <div class="title">{{ $tv['name'] }}</div>
                <ul class="facts">
                    @if ($tv['first_air_date'])
                    <li>
                        <div class="release-date">Comes out on the {{ \Carbon\Carbon::parse($tv['first_air_date'])->format('d/m/Y') }}
                            @if(isset($tv['in_production']) && $tv['in_production'])
                            to the present
                            @elseif(isset($tv['last_air_date']))
                            to {{ \Carbon\Carbon::parse($tv['last_air_date'])->format('d/m/Y') }}
                            @endif
                        </div>
                    </li>
                    @endif
                    @if ($tv['genres'])
                    <li>
                        <div class="genres">{{ implode(', ', $tv['genre_names']) }}</div>
                    </li>
                    @endif
                </ul>
                <div class="horizontal-menu">
                    <div class="rating-number {{ $tv['vote_average'] < 5 ? 'low' : ($tv['vote_average'] < 7 ? 'medium' : 'high') }}">
                        {{ number_format($tv['vote_average'], 1) }}
                    </div>
                    <div class="buttons-container" id="buttons-container">
                        <button class="btn bookmark-btn {{ $isInWatchLater ? 'focused' : '' }}" title="Watch later" data-movie-id="{{ $tv['id'] }}" data-list-type="watch_later" data-url="{{ route('watchlist.toggle') }}" data-media-type="{{ $tv['media_type'] }}">
                            <i class="fa fa-bookmark"></i>
                        </button>
                        <button class="btn heart-btn {{ $isFavorite ? 'focused' : '' }}" title="Add to favorites" data-movie-id="{{ $tv['id'] }}" data-list-type="favorites" data-url="{{ route('watchlist.toggle') }}" data-media-type="{{ $tv['media_type'] }}">
                            <i class="fa fa-heart"></i>
                        </button>
                        <button id="starButton" class="btn star-btn" data-movie-id="{{ $tv['id'] }}" data-url="{{ route('rating.toggle') }}" data-media-type="{{ $tv['media_type'] }}">
                            <div class="btn-content {{ $userRating ? 'btn-content-wide' : '' }}" id="btn-star-content">
                                <div class="btn-star-text {{ $userRating ? '' : 'hidden' }}" id="btn-star-text">Delete the rating</div>
                                <i class="fa fa-star" id="iconStar">
                                    <span id="selectedNumber" class="{{ $userRating ? '' : 'hidden' }}">{{ $userRating ? $userRating->rating_value : '' }}</span>
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
                    <div class="tagline"><i>{{ $tv['tagline'] }}</i></div>
                    <div class="overview">Overview</div>
                    {{ $tv['overview'] }}
                </div>
                <div class="director-container">
                    <div class="director-info">
                        {{ collect($tv['creators'])->pluck('name')->implode(', ') }}
                    </div>
                    <div class="director">
                        Creator
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
                    <img class="card-img-actor" src="{{ 'https://image.tmdb.org/t/p/w185' . $actor['photo'] }}" alt="Card image cap">
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
                <div class="original-title-value">{{ $tv['original_name'] }}</div>
            </div>
            <div class="status">Status
                <div class="status-value">{{ $tv['status'] }}</div>
            </div>
            <div class="the-original-language">The original language
                <div class="language-value">{{ $tv['original_language'] }}</div>
            </div>

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
        <div class="reviews-container">
            @include('layouts/slider-reviews')
            <div class="gradient-menu-right"></div>
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