<?php

namespace Admin\Providers;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'admin');

        if (method_exists($this, 'publishes')) {
            $this->publishes([
                __DIR__ . '/../Resources/assets/css' => base_path('public/css/admin')
            ], 'public');
        }
    }

    public function register()
    {
        //
    }
}
