<?php

namespace OkamiChen\TmsTask;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use OkamiChen\TmsTask\Entity\Task;
use OkamiChen\TmsTask\Observer\TaskObserver;
use OkamiChen\TmsTask\Entity\TaskNode;
use OkamiChen\TmsTask\Observer\TaskNodeObserver;

class TaskServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $commands = [
        'OkamiChen\TmsTask\Console\Command\ExecuteCommand',
    ];
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(dirname(__DIR__).'/resources/views', 'tms-task');
        
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../config' => config_path()], 'tms-task-config');
            $this->publishes([__DIR__.'/../resources/views' => resource_path('views/vendor/tms/task')],'tms-task-views');
            $this->publishes([__DIR__.'/../database/migrations' => database_path('migrations')], 'tms-task-migrations');
        }
        
        $this->registerRoute();
        $this->registerObserver();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }
    
    protected function registerRoute(){
        
        $attributes = [
            'prefix'     => config('admin.route.prefix'),
            'namespace'  => 'OkamiChen\TmsTask\Controller',
            'middleware' => config('admin.route.middleware'),
        ];

        Route::group($attributes, function (Router $router) {
            $router->resource('task/execute', 'TaskExecuteController',['as'=>'tms']);
            $router->resource('task', 'TaskController',['as'=>'tms']);
        });
    }
    
    protected function registerObserver(){
        Task::observe(TaskObserver::class);
        TaskNode::observe(TaskNodeObserver::class);
    }
}
