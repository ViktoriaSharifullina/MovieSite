@extends('layouts/app')

@section('style')
@vite(['resources/css/people/people.css'])
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
        <div class="personal-info-container">
            Personal information
            <div class="personal-info">
                <div class="known-for-department">
                    @if ($person['known_for_department'])
                    Fame for
                    <p class="known-for-val">
                        {{ $person['known_for_department'] }}
                    </p>
                    @endif
                </div>
                <div class="gender">
                    @if ($person['gender'])
                    Gender
                    <p class="gender-val">
                        {{ $person['gender'] === 2 ? 'Male' : 'Female' }}
                    </p>
                    @endif
                </div>
                <div class="birthday">
                    @if ($person['birthday'])
                    Birthday
                    <p class="birthday-val">
                        {{ \Carbon\Carbon::parse($person['birthday'])->format('F j, Y') }} ({{ \Carbon\Carbon::parse($person['birthday'])->age }})
                    </p>
                    @endif
                </div>
                <div class="deathday">
                    @if ($person['deathday'])
                    Deathday:
                    <p>
                        {{ \Carbon\Carbon::parse($personData['deathday'])->format('F j, Y') }}
                    </p>
                    @endif
                </div>
                <div class="place-of-birth">
                    @if ($person['place_of_birth'])
                    Place of Birth:
                    <p class="place-val">
                        {{ $person['place_of_birth'] }}
                    </p>
                    @endif
                </div>
                <div class="also-known-as">
                    @if ($person['also_known_as'])
                    Also Known As:
                    <p class="known-as">
                        {{ implode(', ', $person['also_known_as']) }}
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="people-right-container">
        <div class="people-name-container">
            <div class="people-name">{{ $person['name'] }}</div>
        </div>
        @if ($person['biography'])
        <div class="biography-container">
            <div class="biography">Biography</div>
            <p>{{ $person['biography'] }}</p>
        </div>
        @endif
        <div class="known-for-container">
            <div class="known-for-title">Known For</div>
            <div class="known-movies">
                @foreach ($knownForMovies as $movieId => $movie)
                <a class="card card-movie" href="{{ route('movie.about', $movie['id']) }}">
                    <div class="movie-img">
                        @if(isset($movie['poster_path']))
                        <img class="card-img" src="{{ 'https://image.tmdb.org/t/p/w185' . $movie['poster_path'] }}" alt="Card image cap">
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