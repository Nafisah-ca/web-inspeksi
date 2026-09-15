<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Gates
        Gate::define('admin', fn(User $user) => $user->role === 'admin');
        Gate::define('inspector', fn(User $user) => in_array($user->role, ['inspector', 'admin']));
        Gate::define('customer', fn(User $user) => $user->role === 'customer');
    }
}
