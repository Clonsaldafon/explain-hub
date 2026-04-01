<?php

namespace Admin\Providers;

use Admin\Services\UserStatisticsService;
use Admin\Services\QuestionStatisticsService;
use Admin\Services\AdminDashboardService;
use Framework\Container\ContainerInterface;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function register()
    {
        $container = $this->app->make(ContainerInterface::class);

        $container->bind(UserStatisticsService::class, UserStatisticsService::class);
        $container->bind(QuestionStatisticsService::class, QuestionStatisticsService::class);
        $container->bind(AdminDashboardService::class, AdminDashboardService::class);
    }

    public function boot()
    {
    }
}