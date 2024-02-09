@extends('layouts/app')

@section('style')
@vite(['resources/css/people.css'])
@endsection

@section('content')
<div class="content-container">
    <div class="people-left-container">
        <div class="photo-container">
            @if(isset($person['profile_path']))
            <img src="https://image.tmdb.org/t/p/original/{{ $person['profile_path'] }}" alt="{{ $person['name'] }} Photo">
            @else
            <div class="no-image-overlay" style="height:418px;">
                <span class="no-image-placeholder">No Image</span>
            </div>
            @endif
        </div>
    </div>
    <div class="people-right-container">
        <div class="people-name-container">
            <div class="people-name">{{ $person['name'] }}</div>
        </div>
        <div class="biography-container">
            <div class="biography">Biography</div>
            <p>{{ $person['biography'] }}</p>
        </div>
        <div class="known-for-container">
            <h2>Known For</h2>
            <div class="known-movies">
                @foreach ($knownForMovies as $movieId => $movie)
                <a class="card card-movie" href="#">
                    <div class="movie-img">
                        @if(isset($movie['poster_path']))
                        <img class="card-img" src="{{ 'https://image.tmdb.org/t/p/w500' . $movie['poster_path'] }}" alt="Card image cap">
                        @else
                        <div class="no-image-overlay">
                            <span class="no-image-placeholder">No Image</span>
                        </div>
                        @endif
                    </div>
                    <div class="card-body movie-card-body">
                        @if(isset($movie['original_name']))
                        <div class="card-title">{{ $movie['original_name'] }}</div>
                        @elseif(isset($movie['original_title']))
                        <div class="card-title">{{ $movie['original_title'] }}</div>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
            <div class="gradient"></div>
        </div>
    </div>
</div>
@endsection


@section('script')

@endsection