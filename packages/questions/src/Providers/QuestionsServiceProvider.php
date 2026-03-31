<?php

namespace Questions\Providers;

use Illuminate\Support\ServiceProvider;

class QuestionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Migrations');

        // $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        // $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'questions');

        // if (method_exists($this, 'publishes')) {
        //     $this->publishes([
        //         __DIR__ . '/../Resources/assets/css' => base_path('public/css/questions')
        //     ], 'public');
        // }
    }

    public function register()
    {

    }
}