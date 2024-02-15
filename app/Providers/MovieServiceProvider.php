<?php

namespace App\Providers;

use App\Services\MovieService;
use App\Services\MovieApiService;
use Illuminate\Support\ServiceProvider;

class MovieServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(MovieService::class, function ($app) {
            return new MovieService($app->make(MovieApiService::class));
        });

        $this->app->singleton(MovieApiService::class, function () {
            return new MovieApiService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
