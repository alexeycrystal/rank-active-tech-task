<?php

namespace App\Providers;

use App\Services\TaskResultService;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class TaskResultsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Services\TaskResultService', function (Application $app){
            return new TaskResultService(
                $this->app->make('App\Repositories\TaskRepository')
            );
        });
        $this->app->bind(
            'App\Services\Contracts\TaskResultServiceInterface',
            'App\Services\TaskResultService'
        );
    }
}
