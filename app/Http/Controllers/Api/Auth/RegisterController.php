<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RegisterController extends BaseController
{
    public function __invoke(RegisterRequest $request)
    {
        $user = User::forceCreate([
            'username' => $request->input('user.username'),
            'email' => $request->input('user.email'),
            'password' => Hash::make($request->input('user.password')),
        ]);

        event(new Registered($user));

        $user->refresh();
        $user->token = $user->getToken();
        return new UserResource($user);
    } 
}
