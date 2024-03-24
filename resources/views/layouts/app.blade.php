<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <a class="dropbtn {{ Request::is('movie-catalog*') ? 'active' : '' }}">Movies</a>
                        <div class="dropdown-content">
                            <a href="{{ route('movie.catalogBasic', ['sort' => 'popular']) }}">Popular</a>
                            <a href="{{ route('movie.catalogBasic', ['sort' => 'upcoming']) }}">Upcoming</a>
                            <a href="{{ route('movie.catalogBasic', ['sort' => 'top_rated']) }}">Top Rated</a>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a class="dropbtn {{ Request::is('series-catalog') ? 'active' : '' }}">Shows</a>
                        <div class="dropdown-content">
                            <a href="/series-catalog">Popular</a>
                            <a href="/series-catalog">On TV</a>
                            <a href="/series-catalog">Top Rated</a>
                        </div>
                    </li>
                    <li><a class="menu-list-item {{ Request::is('people-catalog') ? 'active' : '' }}" href="/people-catalog">People</a></li>
                    <li><a class="menu-list-item {{ Request::is('communities') ? 'active' : '' }}" href="#">Communities</a></li>
                </ul>
            </div>
            <li class="dropdown profile-dropdown">
                <div class="profile-container">
                    <a class="dropbtn profile-dropbtn">
                        <div class="profile-picture">
                            <i class="fa-solid fa-user"></i>
                            <!-- <img class="profile-picture" src="{{ Vite::asset('resources/img/profile.jpg') }}" alt=""> -->
                        </div>
                        <div class="profile-text-container">
                            <span class="profile-text">Profile</span>
                            <i class="fa fa-caret-down" aria-hidden="true"></i>
                        </div>
                    </a>
                    <div class="dropdown-content">
                        @guest
                        <a href="#" id="loginLink">Sign in</a>
                        <a href="#" id="signupLink">Sign up</a>
                        @endguest

                        @auth
                        <a href="#">Profile</a>
                        <a href="#">Messages</a>
                        <a href="{{ route('logout') }}">Log out</a>
                        @endauth
                    </div>
                </div>
            </li>
        </div>
    </div>

    <div id="overlay" class="overlay-modal">
        <div id="loginModal" class="container-modal-window">
            <label for="show" class="close-btn fas fa-times" title="close"></label>
            <div class="text">
                Sign in
            </div>
            <form action="#">
                <div class="data">
                    <label>Email<div class="req">*</div></label>
                    <input type="email" required class="input-modal">
                </div>
                <div class="data">
                    <label>Password<div class="req">*</div></label>
                    <input type="password" required class="input-modal">
                </div>
                <div class="btn btn-login">
                    <div class="inner"></div>
                    <button type="submit">LOGIN</button>
                </div>
                <div class="signup-link" id="signup-link">
                    Not a member? <a href="#">Sign up now</a>
                </div>
            </form>
        </div>

        <div id="signupModal" class="container-modal-window">
            <label for="show" class="close-btn fas fa-times" title="close"></label>
            <div class="text">
                Sign up
            </div>
            <form action="{{ route('register') }}" method="POST" id="signupForm" data-url="{{ route('register') }}">
                @csrf
                <div class="data">
                    <label>Username<div class="req">*</div></label>
                    <input type="text" name="username" class="input-modal">
                </div>
                <div class="row">
                    <div class="col">
                        <div class="data">
                            <label>Gender</label>
                            <select class="form-select">
                                <option value="m">Male</option>
                                <option value="f">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="data">
                            <label>Birthday</label>
                            <input type="date" name="birthday" class="input-modal-date">
                        </div>
                    </div>
                </div>

                <div class="data">
                    <label>Email<div class="req">*</div></label>
                    <input type="email" name="email" class="input-modal">
                </div>
                <div class="data">
                    <label>Password<div class="req">*</div></label>
                    <input type="password" name="password" class="input-modal">
                </div>
                <div class="data">
                    <label>Password repeat<div class="req">*</div></label>
                    <input type="password" id="password_confirmation" class="input-modal" name="password_confirmation">
                </div>
                <div class="errors-container"></div>
                <div class="btn btn-signup">
                    <div class="inner"></div>
                    <button type="submit">SIGNUP</button>
                </div>
                <div class="login-link" id="login-link">
                    Already a member? <a href="#">Sign in now</a>
                </div>
            </form>
        </div>
    </div>


    @yield('content')

    <div class="container footer-container">
        <footer class="py-3 footer">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            </ul>
            <p class="text-center footer-text">© 2024 KinoFlow</p>
        </footer>
    </div>

    <script src="https://kit.fontawesome.com/04c178ddc6.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    @vite(['resources/js/app.js'])
    @yield('script')
</body>

</html>