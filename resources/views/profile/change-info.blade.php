@extends('layouts/app')

@section('style')
@vite(['resources/css/profile/change-info.css'])
@endsection

@section('content')
<form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="main-container">
        <div class="photo-container">
            @if($user->photo)
            <img src="{{ asset('storage/' . $user->photo) }}" alt="User Photo">
            @endif
        </div>
        <div class="info-container-1">
            <div class="title-info">Profile Info</div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="row-inputs">
                <div class="input-title">
                    Username
                    <input type="text" class="profile-form user-input" placeholder="Username" value="{{ $user->username }}" name="username">
                </div>
                <div class="input-title">
                    Name
                    <input type="text" class="profile-form name-input" placeholder="Name" value="{{ $user->name }}" name="name">
                </div>
                <div class="input-title">
                    Surname
                    <input type="text" class="profile-form surname-input" placeholder="Surname" value="{{ $user->surname }}" name="surname">
                </div>
            </div>
            <div class="row-inputs">
                <div class="input-title">
                    Birthday
                    <input type="date" class="profile-form birthday-input" name="birthday">
                </div>
                <div class="input-title">
                    Location
                    <input type="text" class="profile-form location-input" placeholder="Location" value="{{ $user->location }}" name="location">
                </div>
                <div class="input-title">
                    Email
                    <input type="email" class="profile-form email-input" placeholder="user@gmail.com" value="{{ $user->email }}" name="email">
                </div>
            </div>
            <div class="row-inputs">
                <div class="input-title">
                    Password
                    <input type="password" class="profile-form password-input" name="password" placeholder="Enter if you want to change it">
                </div>
                <div class="input-title">
                    Repeat password
                    <input type="password" class="profile-form password-input" name="password_confirmation">
                </div>
            </div>
            <div class="row-inputs">
                <div class="input-title">
                    Profile photo
                    <input type="file" class="form-control photo-input" value="{{ $user->photo }}" name="photo">
                </div>
            </div>
        </div>

    </div>

    <div class="info-container-2">
        <button type="submit" class="btn-save">Save</button>
    </div>
</form>
@endsection

@section('script')

@endsection