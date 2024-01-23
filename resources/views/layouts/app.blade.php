<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css'])
    @yield('style')
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Sen:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>KinoFlow</title>
</head>

<body>
    <div class="up-navbar">
        <div class="navbar-container">
            <div class="logo-container">
                <h1 class="logo">KinoFlow</h1>
            </div>
            <div class="menu-container">
                <ul class="menu-list">
                    <li><a class="menu-list-item {{ Request::is('/') ? 'active' : '' }}" href="/">Home</a></li>
                    <li class="dropdown">
                        <a class="dropbtn {{ Request::is('movie-catalog') ? 'active' : '' }}">Movies</a>
                        <div class="dropdown-content">
                            <a href="/movie-catalog">Popular</a>
                            <a href="/movie-catalog">Upcoming</a>
                            <a href="/movie-catalog">Top Rated</a>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a class="dropbtn {{ Request::is('series-catalog') ? 'active' : '' }}">Series</a>
                        <div class="dropdown-content">
                            <a href="/series-catalog">Popular</a>
                            <a href="/series-catalog">On TV</a>
                            <a href="/series-catalog">Top Rated</a>
                        </div>
                    </li>
                    <li><a class="menu-list-item {{ Request::is('people') ? 'active' : '' }}" href="/people">People</a></li>
                    <li><a class="menu-list-item {{ Request::is('communities') ? 'active' : '' }}" href="#">Communities</a></li>
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
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    @yield('script')
</body>

</html>