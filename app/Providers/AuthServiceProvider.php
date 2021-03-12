<?php

namespace App\Providers;

use App\RealWorld\Auth\JwtGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::extend('jwt', function ($app, $name, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\Guard...

            return new JwtGuard(
                Auth::createUserProvider($config['provider']),
                $this->app['request']
            );
        });

        // Auth::viaRequest('jwt', function (Request $request) {
        //     $token = $request->bearerToken();
        //     if (! $token) {
        //         return null;
        //     }

        //     $payload = JWT::decode($token, config('app.key'), ['HS256']);

        //     return User::find($payload->sub);
        // });
    }
}
