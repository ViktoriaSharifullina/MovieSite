<?php

namespace App\Providers;

use App\Services\MovieService;
use App\Services\PeopleService;
use App\Services\MovieApiClient;
use App\Services\PeopleApiClient;
use Illuminate\Support\ServiceProvider;
use App\Http\Contracts\MovieServiceInterface;
use App\Http\Contracts\PeopleServiceInterface;
use App\Http\Contracts\MovieApiClientInterface;
use App\Http\Contracts\PeopleApiClientInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MovieApiClientInterface::class, function ($app) {
            return new MovieApiClient();
        });

        $this->app->bind(MovieServiceInterface::class, function ($app) {
            $movieApiService = $app->make(MovieApiClientInterface::class);
            return new MovieService($movieApiService);
        });

        $this->app->bind(PeopleApiClientInterface::class, function ($app) {
            return new PeopleApiClient();
        });

        $this->app->bind(PeopleServiceInterface::class, function ($app) {
            $movieApiService = $app->make(PeopleApiClientInterface::class);
            return new PeopleService($movieApiService);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
