<?php

namespace App\Providers;

use App\Services\MovieService;
use App\Services\MovieApiService;
use Illuminate\Support\ServiceProvider;
use App\Http\Contracts\MovieApiServiceInterface;
use App\Http\Contracts\MovieDataServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MovieApiServiceInterface::class, function ($app) {
            return new MovieApiService();
        });

        $this->app->bind(MovieDataServiceInterface::class, function ($app) {
            $movieApiService = $app->make(MovieApiServiceInterface::class);
            return new MovieService($movieApiService);
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
