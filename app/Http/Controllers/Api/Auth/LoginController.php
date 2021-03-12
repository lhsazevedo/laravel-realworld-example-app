<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends BaseController
{
    public function __invoke(LoginRequest $request)
    {
        $user = User::where('email', $request->input('user.email'))->first();

        if (! $user or ! Hash::check($request->input('user.password'), $user->password)) {
            throw ValidationException::withMessages([
                'email or password' => ['is invalid'],
            ]);
        }

        $user->token = $user->getToken();
        return new UserResource($user);
    } 
}
