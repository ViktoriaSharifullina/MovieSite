<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(UserStoreRequest $request)
    {
        $user = $this->userService->createUser($request->validated());
        Auth::login($user);
        return response()->json($user, 201);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->userService->updateUser(User::findOrFail($id), $request->validated());
        return response()->json($user, 200);
    }

    public function login(UserLoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json(['message' => 'You are logged in successfully.'], 200);
        }

        return response()->json(['error' => 'The provided credentials do not match our records.'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showProfile($userId = null)
    {
        $user = $userId ? User::findOrFail($userId) : Auth::user();
        $currentUser = Auth::user();

        $seriesCount = $user->seriesCount();
        $moviesCount = $user->moviesCount();
        $favoriteCount = $user->favoriteCount();
        $watchLaterCount = $user->watchLaterCount();

        $isOwnProfile = !$userId || $userId == $currentUser->id;

        $isFriend = !$isOwnProfile && Follow::where('follower_id', $currentUser->id)
            ->where('following_id', $user->id)
            ->exists();

        return view('profile.user-profile', [
            'user' => $user,
            'isOwnProfile' => $isOwnProfile,
            'isFriend' => $isFriend,
            'moviesCount' => $moviesCount,
            'seriesCount' => $seriesCount,
            'favoriteCount' => $favoriteCount,
            'watchLaterCount' => $watchLaterCount
        ]);
    }

    public function editProfile()
    {
        $user = Auth::user();

        return view('/profile/change-info', compact('user'));
    }

    public function updateUser(UpdateUserRequest $request)
    {
        $user = Auth::user();

        $this->userService->updateUser($user, $request->validated());

        return redirect()->route('profile.info', $user->id)->with('success', 'Profile updated successfully!');
    }

    public function show()
    {
        $users = User::all();

        return view('users.users', compact('users'));
    }
}
