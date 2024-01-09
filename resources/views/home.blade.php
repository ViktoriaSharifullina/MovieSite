<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/style.css'])
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Sen:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <title>Movie Site</title>
</head>

<body>
    <div class="navbar">
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
    <div class="container">
        <div class="content-container">

        </div>
    </div>
    <script src="app.js"></script>
</body>

</html>