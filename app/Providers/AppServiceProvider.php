<?php

namespace App\Providers;

use Illuminate\Http\Client\Factory;
use App\Services\TheMovieDbService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerTheMovieDbService();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Registers TheMovieDB service.
     *
     * @return void
     */
    private function registerTheMovieDbService()
    {
        $this->app->bind(
            TheMovieDbService::class,
            function ($app) {
                return new TheMovieDbService(
                    $app->make(Factory::class),
                    config('services.tmdb', [])
                );
            }
        );
    }
}
