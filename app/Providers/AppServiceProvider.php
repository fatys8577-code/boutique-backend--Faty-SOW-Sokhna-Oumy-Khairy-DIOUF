<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('gerer-catalogue', function ($user) {
            return in_array(
                strtolower(trim($user->role)),
                ['gestionnaire', 'admin']
            );
        });

        Gate::define('gerer-utilisateurs', function ($user) {
            return strtolower(trim($user->role)) === 'admin';
        });
    }
}