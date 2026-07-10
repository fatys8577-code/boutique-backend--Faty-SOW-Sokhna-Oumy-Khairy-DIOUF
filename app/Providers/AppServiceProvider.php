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
        Gate::define('gerer-catalogue',function ($user) {
            return in_array($user->role, ['gestionnaire', 'admin']);
        });
        Gate::define('gener-utilisateurs', function ($user) {
            return $user->role === 'admin';
        });
    }
}
