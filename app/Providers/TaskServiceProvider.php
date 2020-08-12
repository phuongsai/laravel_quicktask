<?php

namespace App\Providers;

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
        $this->app->bind(
            'App\Repositories\TaskRepositoryInterface',
            'App\Repositories\TaskRepository'
        );

        $this->app->bind(
            'App\Services\TaskServiceInterface',
            'App\Services\TaskService'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
