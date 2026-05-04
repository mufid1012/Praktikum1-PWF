<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Str;
use Dedoc\Scramble\Scramble;
use Illuminate\Routing\Route;
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
        // Gate: manage-product — hanya admin yang bisa mengakses
        Gate::define('manage-product', function (User $user) {
            return $user->role === 'admin';
        });

        // Gate: manage-category — hanya admin yang bisa mengakses CRUD category
        Gate::define('manage-category', function (User $user) {
            return $user->role === 'admin';
        });

        // Scramble: konfigurasi route API documentation
        Scramble::configure()
            ->routes(function (Route $route) {
                return Str::startsWith($route->uri, 'api/');
            });

        // Gate: viewApiDocs — allow viewing API docs in production
        Gate::define('viewApiDocs', function () {
            return true;
        });
    }
}
