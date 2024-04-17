<?php

namespace App\Services;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;

class FollowService
{
    public function toggleFriendship($userId)
    {
        $userToToggle = User::findOrFail($userId);
        $currentUser = Auth::user();

        $existingFollow = Follow::where('follower_id', $currentUser->id)
            ->where('following_id', $userToToggle->id)
            ->first();

        if ($existingFollow) {
            $existingFollow->delete();
            return ['status' => 'removed', 'message' => 'User has been removed from your friends.'];
        } else {
            $follow = new Follow();
            $follow->follower_id = $currentUser->id;
            $follow->following_id = $userToToggle->id;
            $follow->save();
            return ['status' => 'added', 'message' => 'User has been added to your friends.'];
        }
    }
}
