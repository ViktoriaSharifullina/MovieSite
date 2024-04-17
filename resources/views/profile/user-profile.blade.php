@extends('layouts/app')

@section('style')
@vite(['resources/css/profile/profile.css'])
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow:wght@700&display=swap" rel="stylesheet">
@endsection

@section('content')
<div class="user-profile-container">
    <div class="top-container">
        <div class="user-photo">
            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://as2.ftcdn.net/v2/jpg/03/49/49/79/1000_F_349497933_Ly4im8BDmHLaLzgyKg2f2yZOvJjBtlw5.jpg' }}">
        </div>
        <div class="user-info">
            <div class="user-name">{{ $user->username }}</div>
            <div class="name-and-surname">{{ $user->name }} {{ $user->surname }}</div>
            <div class="email">{{ $user->email }}</div>
            <div class="row-container">
                <div class="location"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $user->location ?? 'Location not set' }}</div>
                <div class="birthday"><i class="fa fa-birthday-cake" aria-hidden="true"></i> {{ $user->birthday ? $user->birthday->format('d.m.Y') : 'Birthday not set' }}</div>
            </div>
            @if($isOwnProfile)
            <a href="{{ route('profile.info') }}" class="btn-change-info">Change</a>
            @else
            <div class="communication-container">
                <button class="btn-add-friend" data-user-id="{{ $user->id }}" data-friend-status="{{ $isFriend ? 'friend' : 'not-friend' }}" data-url="{{ route('toggle.friend', ['userId' => $user->id]) }}" data-csrf-token="{{ csrf_token() }}">
                    {{ $isFriend ? 'Remove from Friends' : 'Add to Friends' }}
                </button>
                <button class="btn-write-msg">Write a message</button>
            </div>
            @endif
        </div>
    </div>
    <div class="profile-menu">
        <a href="{{ route('profile.movies') }}" class="profile-link">
            <div class="item-container">
                <div class="item-container-value">{{ $moviesCount }}</div>
                <div class="item-description">Movies</div>
            </div>
        </a>
        <a href="#" class="profile-link">
            <div class="item-container">
                <div class="item-container-value">{{ $seriesCount }}</div>
                <div class="item-description">Series</div>
            </div>
        </a>
        <a href="#" class="profile-link">
            <div class="item-container">
                <div class="item-container-value">5</div>
                <div class="item-description">Friends</div>
            </div>
        </a>
        <a href="#" class="profile-link">
            <div class="item-container">
                <div class="item-container-value">15</div>
                <div class="item-description">Added to friends</div>
            </div>
        </a>
        <a href="{{ route('profile.list', ['listType' => 'favorites']) }}" class="profile-link">
            <div class="item-container">
                <div class="item-container-value">{{ $favoriteCount }}</div>
                <div class="item-description">Favorite</div>
            </div>
        </a>
        <a href="{{ route('profile.list', ['listType' => 'watch_later']) }}" class="profile-link">
            <div class="item-container">
                <div class="item-container-value">{{ $watchLaterCount }}</div>
                <div class="item-description">Watch later</div>
            </div>
        </a>
    </div>
</div>

@if(!empty($movies))
@php $movieCount = 0; @endphp
<div class="movies-wrapper">
    @foreach ($movies as $details)
    @php $movieCount++; @endphp
    <div class="movie-list-container">
        <div class="movie-container">
            <div class="movie-count">{{ $movieCount }}</div>
            <div class="movie-photo">
                <img src="https://image.tmdb.org/t/p/w342{{ $details['poster_path'] }}" class="movie-poster">
            </div>
            <div class="movie-facts-1">
                <div class="movie-titles">
                    <div class="movie-title">
                        {{ isset($details['title']) ? $details['title'] : $details['name'] }},
                        {{ isset($details['release_date']) ? \Carbon\Carbon::parse($details['release_date'])->format('Y') : \Carbon\Carbon::parse($details['first_air_date'])->format('Y')}}
                    </div>
                    <div class="movie-original-title">{{ isset($details['original_title']) ? $details['original_title'] : $details['original_name'] }},
                        {{ isset($details['formatted_runtime']) ? $details['formatted_runtime'] : "" }}
                    </div>
                </div>
                <div class="movie-facts-2">
                    <div class="movie-description">
                        @foreach ($details['production_countries'] as $country)
                        {{ $country['iso_3166_1'] }}
                        @endforeach
                        @if(isset($details['director']))
                        , dir. {{ $details['director'] }}
                        @elseif(isset($details['created_by'][0]['name']))
                        , created by {{ $details['created_by'][0]['name'] }}
                        @endif
                    </div>
                    <div class="movie-main-genres">
                        @if(!empty($details['genres']) && count($details['genres']) > 0)
                        (
                        @foreach($details['genres'] as $key => $genre)
                        @if($key < 3) {{ $genre['name'] }}@if($key < 2 && count($details['genres'])> 1), @endif
                            @endif
                            @endforeach
                            )
                            @endif
                    </div>
                </div>
            </div>
            <div class="movie-rating">
                <div class="movie-site-rating {{ $details['vote_average'] < 5 ? 'low' : ($details['vote_average'] < 7 ? 'medium' : 'high') }}">{{ number_format($details['vote_average'], 1) }}</div>
                <div class="movie-user-rating">{{ $details['user_rating'] ?? 'Not rated' }}</div>
                <div class="movie-actions">
                    <li class="drop-btn">
                        <a class="dropbtn"><i class="fa-solid fa-play"></i></a>
                        <div class="drop-content">
                            <a href="#">Delete rating</a>
                            <a href="#">Delete from the list</a>
                        </div>
                    </li>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

@endsection

@section('script')
@vite(['resources/js/profile.js'])
@vite(['resources/js/follow.js'])
@endsection