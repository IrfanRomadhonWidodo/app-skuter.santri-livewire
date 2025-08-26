<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        $this->registerPolicies();

        // Gate untuk admin
        Gate::define('isAdmin', function (User $user) {
            return $user->role === 'admin';
        });

        // Gate untuk mahasiswa
        Gate::define('isMahasiswa', function (User $user) {
            return $user->role === 'mahasiswa';
        });
    }
}
