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
                                <button class="sort-dropbtn" id="sortButton" data-sort="popularity-desc">
                                    Popularity (descending)
                                    <i class="fa-solid fa-caret-down sort-caret" id="sortCaretIcon"></i>
                                </button>
                                <div class="sort-dropdown-content" id="sortContent">
                                    <a href="#" class="sort-option" data-sort="popularity-desc">Popularity (descending)</a>
                                    <a href="#" class="sort-option" data-sort="popularity-asc">Popularity (ascending)</a>
                                    <a href="#" class="sort-option" data-sort="rating-desc">Rating (descending)</a>
                                    <a href="#" class="sort-option" data-sort="rating-asc">Rating (ascending)</a>
                                    <a href="#" class="sort-option" data-sort="release-desc">Release date (descending)</a>
                                    <a href="#" class="sort-option" data-sort="release-asc">Release date (ascending)</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filters-menu-container">
                    <div class="filter-menu-title">Filter</div>
                    <div class="filter-menu">
                        <div class="filter-title">Country</div>
                    </div>
                    <div class="filter-dropdown-menu">
                        <button class="filter-dropbtn" id="filterCountryBtn">
                            Сhoose a country
                            <i class="fa-solid fa-caret-down filter-caret" id="filterCaretIcon"></i>
                        </button>
                        <div class="filter-dropdown-content" id="filterCountry">
                            <a href="#" class="country-option" data-country="Australia"><span class="flag-icon flag-icon-au"></span> Australia</a>
                            <a href="#" class="country-option" data-country="Brazil"><span class="flag-icon flag-icon-br"></span> Brazil</a>
                            <a href="#" class="country-option" data-country="Canada"><span class="flag-icon flag-icon-ca"></span> Canada</a>
                            <a href="#" class="country-option" data-country="China"><span class="flag-icon flag-icon-cn"></span> China</a>
                            <a href="#" class="country-option" data-country="France"><span class="flag-icon flag-icon-fr"></span> France</a>
                            <a href="#" class="country-option" data-country="Germany"><span class="flag-icon flag-icon-de"></span> Germany</a>
                            <a href="#" class="country-option" data-country="India"><span class="flag-icon flag-icon-in"></span> India</a>
                            <a href="#" class="country-option" data-country="Italy"><span class="flag-icon flag-icon-it"></span> Italy</a>
                            <a href="#" class="country-option" data-country="Japan"><span class="flag-icon flag-icon-jp"></span> Japan</a>
                            <a href="#" class="country-option" data-country="Mexico"><span class="flag-icon flag-icon-mx"></span> Mexico</a>
                            <a href="#" class="country-option" data-country="Russia"><span class="flag-icon flag-icon-ru"></span> Russia</a>
                            <a href="#" class="country-option" data-country="South Africa"><span class="flag-icon flag-icon-za"></span> South Africa</a>
                            <a href="#" class="country-option" data-country="South Korea"><span class="flag-icon flag-icon-kr"></span> South Korea</a>
                            <a href="#" class="country-option" data-country="Spain"><span class="flag-icon flag-icon-es"></span> Spain</a>
                            <a href="#" class="country-option" data-country="United Kingdom"><span class="flag-icon flag-icon-gb"></span> United Kingdom</a>
                            <a href="#" class="country-option" data-country="United States"><span class="flag-icon flag-icon-us"></span> United States</a>
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
                </div>
            </div>
        </div>
    </div>
    <div class="col-right">
        <div class="right-container">
            <div class="search-container"></div>
            <div class="movie-catalog-container"></div>
        </div>
    </div>

</div>
@endsection

@section('script')
@vite(['resources/js/movie-catalog.js'])
@vite(['resources/js/filter-genres.js'])
@endsection;