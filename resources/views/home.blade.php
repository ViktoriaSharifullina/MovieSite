<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/style.css'])
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Sen:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Movie Site</title>
</head>

<body>
    <div class="up-navbar">
        <div class="navbar-container">
            <div class="logo-container">
                <h1 class="logo">KinoFlow</h1>
            </div>
            <div class="menu-container">
                <ul class="menu-list">
                    <li class="menu-list-item active">Home</li>
                    <li class="menu-list-item">Movies</li>
                    <li class="menu-list-item">Series</li>
                    <li class="menu-list-item">Popular</li>
                    <li class="menu-list-item">Communities</li>
                </ul>
            </div>
            <div class="search-container">
                <form class="search-form">
                    <span class="icon"><i class="fa fa-search"></i></span>
                    <input type="search" id="search" placeholder="Search..." />
                </form>
            </div>
            <div class="profile-container">
                <img class="profile-picture" src="{{ Vite::asset('resources/img/profile.jpg') }}" alt="">
                <div class="profile-text-container">
                    <span class="profile-text">Profile</span>
                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                </div>
                <div class="toggle">
                    <i class="fa fa-moon toggle-icon"></i>
                    <i class="fa fa-sun toggle-icon"></i>
                    <div class="toggle-ball"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-container">
        <div class="content-container">
            <div class="featured-img">
                <img src="{{ 'https://image.tmdb.org/t/p/original/' . $featuredMovie['backdrop_path'] }}" alt="{{ $featuredMovie['title'] }} Backdrop">
            </div>
            <div class="movie-details">
                <div class="title">{{ $featuredMovie['title'] }}</div>
                <ul class="facts">
                    <li>
                        <div class="release-date">{{ $featuredMovie['formatted_release_date'] }}</div>
                    </li>
                    <li>
                        <div class="genres">{{ implode(', ', $featuredMovie['genre_names']) }}</div>
                    </li>
                    <li>
                        <div class="runtime">{{ $featuredMovie['formatted_runtime'] }}</div>
                    </li>
                </ul>
                <div class="desc">{{ $featuredMovie['overview'] }}</div>
                <button type="button" class="feature-button btn btn-light">Read more</button>
            </div>
        </div>

        <div class="movies-container">
            <div class="movies">
                <div class="text-center">
                    @php
                    $moviesChunks = array_chunk($otherMovies, 5);
                    @endphp

                    @foreach($moviesChunks as $moviesRow)
                    <div class="row-movie row mb-5 justify-content-center">
                        @foreach($moviesRow as $movie)
                        <div class="col">
                            <div class="movie-container">
                                <div class="movie-poster">
                                    <img class="movie-poster" src="{{ 'https://image.tmdb.org/t/p/original/' . $movie['poster_path'] }}" alt="{{ $movie['title'] }} Poster">
                                    <button class="bookmark-btn" title="Watch later">
                                        <i class="fa fa-bookmark"></i>
                                    </button>
                                    <div class="rating {{ $movie['vote_average'] < 5 ? 'low' : ($movie['vote_average'] < 7 ? 'medium' : 'high') }}">
                                        {{ number_format($movie['vote_average'], 1) }}
                                    </div>
                                </div>
                                <div class="movie-facts">
                                    <div class="movie-title">
                                        {{ $movie['title'] }}
                                    </div>
                                    <span class="release-year">{{ $movie['release_year'] }}, </span>
                                    <span class="primary-genre">{{ $movie['primary_genre'] }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    @vite(['resources/js/homepage.js'])
</body>

</html>