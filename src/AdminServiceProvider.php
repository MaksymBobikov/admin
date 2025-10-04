<?php

namespace Maksb\Admin;

use Illuminate\Support\ServiceProvider;
use Maksb\Admin\Console\commands\AdminInstallCommand;
use Maksb\Admin\Http\Middleware\AuthMiddleware;

class AdminServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->commands([
            AdminInstallCommand::class
        ]);

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'maksb/admin');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $router = $this->app['router'];
        $router->aliasMiddleware('auth', AuthMiddleware::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/admin-auth.php' => config_path('admin-auth.php'),
            ], 'config');
            $this->publishes([
                __DIR__ . '/../resources/admin/js' => resource_path('admin/js'),
                __DIR__ . '/../resources/admin/css' => resource_path('admin/css')
            ], 'assets');
        }
    }

    public function register(): void
    {

    }
}
