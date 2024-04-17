<?php

namespace App\Http\Controllers;

use App\Services\FollowService;


class FollowController extends Controller
{
    protected $followService;

    public function __construct(FollowService $followService)
    {
        $this->followService = $followService;
    }

    public function toggleFriend($userId)
    {
        $result = $this->followService->toggleFriendship($userId);
        return response()->json($result);
    }
}
