<?php

namespace App\Providers;

use App\Constants\Theme;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Services\DashboardService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

require_once __DIR__ . '/../../server-config.php';

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('path.public', function () {
            return PUBLIC_PATH;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('THEME', Theme::class);

        $this->app->bind(DashboardController::class, function ($app) {
            return new DashboardController($app->make(DashboardService::class));
        });

        $this->app->bind(UserController::class, function ($app) {
            return new UserController($app->make(UserService::class));
        });
    }
}
