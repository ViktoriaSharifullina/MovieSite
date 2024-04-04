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
            @if($user->photo)
            <img src="{{ asset('storage/' . $user->photo) }}" alt="User Photo">
            @endif
        </div>
        <div class="user-info">
            <div class="user-name">{{ $user->username }}</div>
            <div class="name-and-surname">{{ $user->name }} {{ $user->surname }}</div>
            <div class="email">{{ $user->email }}</div>
            <div class="row-container">
                <div class="location"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $user->location ?? 'Location not set' }}</div>
                <div class="birthday"><i class="fa fa-birthday-cake" aria-hidden="true"></i> {{ $user->birthday ? $user->birthday->format('d.m.Y') : 'Birthday not set' }}</div>
            </div>
            <a href="{{ route('profile.info') }}" class="btn-change-info">Change</a>
        </div>
    </div>
    <div class="profile-menu">
        <a href="#" class="profile-link">
            <div class="item-container">
                <div class="item-container-value">441</div>
                <div class="item-description">Movies</div>
            </div>
        </a>
        <a href="#" class="profile-link">
            <div class="item-container">
                <div class="item-container-value">121</div>
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
                <div class="item-container-value">36</div>
                <div class="item-description">Favorite movies</div>
            </div>
        </a>
        <a href="{{ route('profile.list', ['listType' => 'watch_later']) }}" class="profile-link">
            <div class="item-container">
                <div class="item-container-value">10</div>
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
                    <div class="movie-title">{{ $details['title'] }} ({{ \Carbon\Carbon::parse($details['release_date'])->format('Y') }})</div>
                    <div class="movie-original-title">{{ $details['original_title'] }}, {{ $details['formatted_runtime'] }}</div>
                </div>
                <div class="movie-facts-2">
                    <div class="movie-description">
                        @foreach ($details['production_countries'] as $country)
                        {{ $country['iso_3166_1'] }}
                        @endforeach
                        , dir. {{ $details['director'] }}
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
                <div class="movie-user-rating">8</div>
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
@endsection