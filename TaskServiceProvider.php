<?php

namespace OkamiChen\TmsMobile;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

class TaskServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../config' => config_path()], 'tms-task-config');
            $this->publishes([__DIR__.'/../database/migrations' => database_path('migrations')], 'tms-task-migrations');
        }
        
        $this->registerRoute();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    
    protected function registerRoute(){
        
        $attributes = [
            'prefix'     => config('admin.route.prefix'),
            'namespace'  => 'OkamiChen\TmsTask\Controller',
            'middleware' => config('admin.route.middleware'),
        ];

        Route::group($attributes, function (Router $router) {
            $router->resource('task', 'TaskController',['as'=>'tms']);
        });
    }
}
