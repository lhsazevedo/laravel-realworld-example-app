<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Resources\ProfileResource;
use App\Models\User;

class ProfileController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    public function show(User $user)
    {
        // dd($user->following);
        return new ProfileResource($user);
    }

    /**
     * Follow the user given by their username and return the user if successful.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function follow(User $user)
    {
        $authenticatedUser = auth()->user();

        $authenticatedUser->follow($user);

        return new ProfileResource($user);
    }

    /**
     * Unfollow the user given by their username and return the user if successful.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function unFollow(User $user)
    {
        $authenticatedUser = auth()->user();

        $authenticatedUser->unFollow($user);

        return new ProfileResource($user);
    }
}
