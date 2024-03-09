@extends ('layouts/app')

@section('style')
@vite(['resources/css/movie/movie-catalog.css'])
<link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="main-container">
    <div class="col-left">
        <div class="left-container">
            <div class="left-menu-container">
                <form action="{{ route('movie.catalogAdvanced') }}" method="GET" id="formFilter">
                    <!-- Скрытые поля для передачи параметров сортировки и фильтрации -->
                    <input type="hidden" name="sort_by" id="hiddenSortField">
                    <input type="hidden" name="language" id="hiddenLanguageField">
                    <input type="hidden" name="release_date_gte" id="hiddenReleaseDateGteField">
                    <input type="hidden" name="release_date_lte" id="hiddenReleaseDateLteField">
                    <input type="hidden" name="genre" id="hiddenGenresField">
                    <div class="sort-menu-container">
                        <div class="sort-dropdown-menu">
                            <button class="sort-dropbtn-menu" id="sortButtonMenu">Sort
                                <i class="fa-solid fa-angle-right right-arrow" id="arrow"></i>
                            </button>
                            <div class="sort-dropdown-content-menu" id="sortContentMenu">
                                <div class="title-sort">
                                    Sort the results by
                                </div>
                                <div class="sort-dropdown">
                                    <button class="sort-dropbtn" id="sortButton">
                                        Nothing is selected
                                        <i class="fa-solid fa-caret-down sort-caret" id="sortCaretIcon"></i>
                                    </button>
                                    <div class="sort-dropdown-content" id="sortContent">
                                        <a href="#" class="sort-option" data-sort="popularity.desc">Popularity (descending)</a>
                                        <a href="#" class="sort-option" data-sort="popularity.asc">Popularity (ascending)</a>
                                        <a href="#" class="sort-option" data-sort="vote_average.desc">Rating (descending)</a>
                                        <a href="#" class="sort-option" data-sort="vote_average.asc">Rating (ascending)</a>
                                        <a href="#" class="sort-option" data-sort="release_date.desc">Release date (descending)</a>
                                        <a href="#" class="sort-option" data-sort="release_date.asc">Release date (ascending)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filters-menu-container">
                        <div class="filter-menu-title">Filter</div>
                        <div class="filter-menu">
                            <div class="filter-title">Language</div>
                        </div>
                        <div class="filter-dropdown-menu">
                            <button class="filter-dropbtn" id="filterLanguageBtn">
                                Nothing is selected
                                <i class="fa-solid fa-caret-down filter-caret" id="filterCaretIcon"></i>
                            </button>
                            <div class="filter-dropdown-content" id="filterLanguage">
                            </div>
                        </div>
                        <div class="filter-menu">
                            <div class="filter-title">Release dates</div>
                            <div class="filter-release-container">
                                <div class="from">
                                    <div class="release-title">from</div>
                                    <input type="date" class="input-release-date-from" id="inputFrom">
                                </div>
                                <div class="before">
                                    <div class="release-title">before</div>
                                    <input type="date" class="input-release-date-before" id="inputBefore">
                                </div>
                            </div>
                        </div>
                        <div class="filter-menu">
                            <div class="filter-title">Genres</div>
                            <ul id="filterGenres" class="filter-genres-container"></ul>
                        </div>
                        <button type="submit" class="btn-search-filters">Search by filters</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="col-right">
    <div class="right-container">
        <div class="search-container">
            <form id="search-form" action="" method="GET">
                <input type="text" class="search-input" id="search-input" name="query" placeholder="Search for movies...">
                <button type="submit" class="btn-search">Search</button>
            </form>
        </div>
        <div class="movie-catalog-container">
            <div class="movie-list-container">
                <div class="movie-list-title">
                    @switch($currentSort)
                    @case('popular')
                    Popular
                    @break
                    @case('upcoming')
                    Upcoming
                    @break
                    @case('top_rated')
                    Top Rated
                    @break
                    @default
                    Movies
                    @endswitch
                </div>

                <div class="movie-list">
                    @if(!empty($moviesData))
                    @foreach($moviesData as $movie)
                    <div class="movie-list-item">
                        <a href="{{ route('movie.about', $movie['id']) }}">
                            <div class="movie-poster">
                                @if(isset($movie['poster_path']))
                                <img src="https://image.tmdb.org/t/p/w185{{ $movie['poster_path'] }}" class="movie-poster">
                                @else
                                <img src="/path/to/default/poster.jpg" class="movie-poster">
                                @endif
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
                    @else
                    <p>No movies found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>

</div>
@endsection

@section('script')
@vite(['resources/js/movie-catalog.js', 'resources/js/filter-genres.js'])
@endsection;