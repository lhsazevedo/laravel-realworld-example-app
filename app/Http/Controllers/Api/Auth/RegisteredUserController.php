<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends BaseController
{
    public function __invoke(RegistrationRequest $request)
    {
        Auth::login($user = User::create([
            'username' => $request->input('user.username'),
            'email' => $request->input('user.email'),
            'password' => Hash::make($request->input('user.password')),
        ]));

        event(new Registered($user));

        $user->refresh();
        $user->token = $user->getToken();
        return new UserResource($user);
    } 
}
