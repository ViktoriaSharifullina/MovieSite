<?php

namespace App\Providers;

use App\Services\MovieService;
use App\Services\MovieApiClient;
use Illuminate\Support\ServiceProvider;

class MovieServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(MovieService::class, function ($app) {
            return new MovieService($app->make(MovieApiClient::class));
        });

        $this->app->singleton(MovieService::class, function () {
            return new MovieApiClient();
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
