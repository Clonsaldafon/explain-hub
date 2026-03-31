<?php

namespace Questions\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

use Questions\View\Components\Question;
use Questions\View\Components\TagList;

class QuestionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Migrations');

        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'questions');

        if (method_exists($this, 'publishes')) {
            $this->publishes([
                __DIR__ . '/../Resources/assets/css' => base_path('public/css/questions')
            ], 'public');
        }

        Blade::component('question', Question::class);
        Blade::component('tag-list', TagList::class);
    }

    public function register()
    {

    }
}