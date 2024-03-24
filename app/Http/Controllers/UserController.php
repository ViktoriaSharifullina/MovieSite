<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserStoreRequest;
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
        // Auth::login($user);
        return response()->json($user, 201);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->userService->updateUser(User::findOrFail($id), $request->validated());
        return response()->json($user, 200);
    }
}
