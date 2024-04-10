<?php

namespace App\Providers;

use App\Services\TvService;
use App\Services\TvApiClient;
use App\Services\MovieService;
use App\Services\PeopleService;
use App\Services\RatingService;
use App\Services\MovieApiClient;
use App\Services\PeopleApiClient;
use App\Services\UserProfileService;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(MovieService::class, function ($app) {
            return new MovieService($app->make(MovieApiClient::class));
        });

        $this->app->singleton(TvService::class, function ($app) {
            return new TvService($app->make(TvApiClient::class));
        });

        $this->app->singleton(MovieApiClient::class, function ($app) {
            return new MovieApiClient();
        });

        $this->app->singleton(TvApiClient::class, function ($app) {
            return new TvApiClient();
        });

        $this->app->singleton(PeopleApiClient::class, function ($app) {
            return new PeopleApiClient();
        });

        $this->app->singleton(PeopleService::class, function ($app) {
            return new PeopleService($app->make(PeopleApiClient::class));
        });

        $this->app->singleton(UserProfileService::class, function ($app) {
            return new UserProfileService(
                $app->make(MovieService::class),
                $app->make(RatingService::class),
                $app->make(TvService::class)
            );
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
