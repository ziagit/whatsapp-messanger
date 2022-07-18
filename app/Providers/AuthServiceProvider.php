<?php

namespace App\Providers;

use App\Guard\JWTGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        $this->app['auth']->extend(
            'jwt-auth', 
            function ($app, $name, array $config) {
              $guard = new JWTGuard(
                $app['tymon.jwt'],
                $app['request']
              );
              $app->refresh('request', $guard, 'setRequest');
              return $guard;
            }
          );
    }
}
