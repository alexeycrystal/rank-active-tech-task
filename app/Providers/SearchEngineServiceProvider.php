<?php

namespace App\Providers;

use App\Services\SearchEngineService;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class SearchEngineServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->app->singleton('App\Services\SearchEngineService', function (Application $app){
            return new SearchEngineService();
        });
        $this->app->bind(
            'App\Services\Contracts\SearchEngineServiceInterface',
            'App\Services\SearchEngineService'
        );
    }
}
