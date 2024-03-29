@extends ('layouts/app')

@section('style')
@vite(['resources/css/people/people-catalog.css'])
@endsection

@section('content')
<div class="container-people-catalog">
    <form id="search-form" action="{{ route('people.catalog') }}" method="GET">
        <input type="text" class="search-input" id="search-input" name="query" placeholder="Search for actors...">
        <button type="submit" class="btn-search">Search</button>
    </form>

    @if($searchPerformed)
    <div class="search-container">
        @forelse($searchResults as $person)
        <a class="card card-actor" href="{{ route('people.about', $person['id']) }}">
            @if(isset($person['profile_path']))
            <img class="card-img-actor" src="https://image.tmdb.org/t/p/w200{{ $person['profile_path'] }}" alt="{{ $person['name'] }}" style="height: 160px;">
            @else
            <div class="no-image-overlay" style="height: 160px;">
                <span class="no-image-placeholder">No Image</span>
            </div>
            @endif
            <div class="actor-card-body">
                <div class="actor-name">{{ $person['name'] }}</div>
            </div>
        </a>
        @empty
        <div class="no-people-found">No actors found.</div>
        @endforelse
    </div>
    @endif

    <div class="compilations-container">
        <div class="compilations-container-title">Most popular</div>
        <div class="people-cards-container">
            @foreach($popularPeople as $person)
            <a class="card card-actor" href="{{ route('people.about', $person['id']) }}">
                @if(isset($person['profile_path']))
                <img class="card-img-actor" src="https://image.tmdb.org/t/p/w200{{ $person['profile_path'] }}" alt="{{ $person['name'] }}" style="height: 160px;">
                @else
                <div class="no-image-overlay" style="height: 160px;">
                    <span class="no-image-placeholder">No Image</span>
                </div>
                @endif
                <div class="actor-card-body">
                    <div class="actor-name">{{ $person['name'] }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>

@endsection

@section('script')
<!-- @vite(['resources/js/people-catalog.js']) -->
@endsection;