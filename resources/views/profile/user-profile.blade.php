@extends('layouts/app')

@section('style')
@vite(['resources/css/profile/profile.css'])
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow:wght@700&display=swap" rel="stylesheet">
@endsection

@section('content')
<div class="user-profile-container">
    <div class="top-container">
        <div class="user-photo"></div>
        <div class="user-info">
            <div class="user-name">{{ $user->username }}</div>
            <div class="name-and-surname">{{ $user->name }} {{ $user->surname }}</div>
            <div class="email">{{ $user->email }}</div>
            <div class="row-container">
                <div class="location"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $user->location ?? 'Location not set' }}</div>
                <div class="birthday"><i class="fa fa-birthday-cake" aria-hidden="true"></i> {{ $user->birthday ? $user->birthday->format('d.m.Y') : 'Birthday not set' }}</div>
            </div>
            <a href="{{ route('change-info') }}" class="btn-change-info">Change</a>
        </div>
    </div>
    <div class="profile-menu">
        <a href="#" class="profile-link">
            <div class="item-container">
                <div class="item-container-value">441</div>
                <div class="item-description">Movies</div>
            </div>
        </a>
        <a href="#" class="profile-link">
            <div class="item-container">
                <div class="item-container-value">121</div>
                <div class="item-description">Series</div>
            </div>
        </a>
        <a href="#" class="profile-link">
            <div class="item-container">
                <div class="item-container-value">5</div>
                <div class="item-description">Friends</div>
            </div>
        </a>
        <a href="#" class="profile-link">
            <div class="item-container">
                <div class="item-container-value">15</div>
                <div class="item-description">Added to friends</div>
            </div>
        </a>
        <a href="#" class="profile-link active">
            <div class="item-container">
                <div class="item-container-value">36</div>
                <div class="item-description">Favorite movies</div>
            </div>
        </a>
        <a href="#" class="profile-link">
            <div class="item-container">
                <div class="item-container-value">10</div>
                <div class="item-description">In bookmarks</div>
            </div>
        </a>
    </div>
</div>
@endsection

@section('script')

@endsection