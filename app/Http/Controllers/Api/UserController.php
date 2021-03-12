<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Requests\UpdateUser;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return new UserResource(auth()->user());
    }

    /**
     * Update the authenticated user and return the user if successful.
     *
     * @param UpdateUser $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUser $request)
    {
        $user = auth()->user();

        if ($request->has('user')) {
            $user->fill($request->user);
        }

        if ($request->has('user.password')) {
            $user->password = Hash::make($request->input('user.password'));
        }

        if ($user->isDirty()) {
            $user->save();
        }

        return new UserResource($user);
    }
}
