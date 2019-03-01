<?php

namespace App\Providers;

use App\Repositories\TaskRepository;
use App\Services\TaskService;
use App\Task;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
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
        $this->app->singleton('App\Repositories\TaskRepository', function(Application $app){
            return new TaskRepository(
                $this->app->make(Task::class)
            );
        });
        $this->app->singleton('App\Services\TaskService', function (Application $app){
            return new TaskService(
                $this->app->make('App\Repositories\TaskRepository')
            );
        });
        $this->app->bind(
            'App\Repositories\Contracts\TaskRepository',
            config('database.eloquent-model-repository.task')
        );
        $this->app->bind(
            'App\Services\Contracts\TaskServiceInterface',
            'App\Services\TaskService'
        );
    }
}
