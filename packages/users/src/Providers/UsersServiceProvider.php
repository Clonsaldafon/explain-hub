<?php

namespace Users\Providers;

use Illuminate\Support\ServiceProvider;

class UsersServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Migrations');

        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'users');

        if (method_exists($this, 'publishes')) {
            $this->publishes([
                __DIR__ . '/../Resources/assets/css' => base_path('public/css/users')
            ], 'public');
        }
    }

    public function register()
    {

    }
}