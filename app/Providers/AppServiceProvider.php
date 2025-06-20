<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::define('access-super-admin-menu', function (User $user) {
            return $user->role === 'super_admin';
        });

        Gate::define('access-admin-menu', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
