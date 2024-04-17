@extends('layouts/app')

@section('style')
@vite(['resources/css/users/users.css'])
@endsection

@section('content')

<div class="search-container">
    <form id="search-form" action="{{ route('movies.search') }}" method="GET">
        <input type="text" class="search-input" id="search-input" name="query" placeholder="Enter the user name...">
        <button type="submit" class="btn-search">Search</button>
    </form>
</div>


<div class="users-cards-container">
    @foreach ($users as $user)
    <a href="{{ route('user.profile', ['userId' => $user->id]) }}" class="user-figure-link">
        <figure class="user-figure">
            <img class="user-image user-clickcircle" src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://as2.ftcdn.net/v2/jpg/03/49/49/79/1000_F_349497933_Ly4im8BDmHLaLzgyKg2f2yZOvJjBtlw5.jpg' }}">
            <figcaption>
                <div class="user-figure-title username">{{ $user->username }}</div>
                <div class="user-figure-title">{{ $user->email }}</div>
            </figcaption>
        </figure>
    </a>
    @endforeach
</div>



@endsection

@section('script')
@vite(['resources/js/users.js'])
@endsection