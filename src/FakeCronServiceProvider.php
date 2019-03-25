<?php

namespace AlexBowers\LaravelFakeCron;

use Illuminate\Support\ServiceProvider;
use AlexBowers\LaravelFakeCron\Commands\Cron;

class FakeCronServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Cron::class,
            ]);
        }
    }
    /**
     * Register the application services.
     */
    public function register()
    {
        // ...
    }
}