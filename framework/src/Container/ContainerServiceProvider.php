<?php

namespace Framework\Container;

use Illuminate\Support\ServiceProvider;
use Framework\Container\Container;

class ContainerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ContainerInterface::class, function ($app) {
            return new Container();
        });

        $this->app->singleton('framework.container', function ($app) {
            return $app->make(ContainerInterface::class);
        });
    }

    public function boot()
    {
        //
    }
}