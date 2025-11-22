<?php

namespace Maksb\Admin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Maksb\Admin\Console\commands\AdminInstallCommand;
use Maksb\Admin\Http\Composers\HeaderComposer;
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

        $this->registerComposers();

        $this->publishMiddleware();

        if ($this->app->runningInConsole()) {
           $this->publishResources();
        }
    }

    public function register(): void
    {
        $this->mergeAuthConfig();
    }

    private function mergeAuthConfig(): void
    {
        $config = require __DIR__ . '/../config/auth.php';

        config(['auth' => array_replace_recursive(config('auth'), $config)]);
    }

    private function publishResources(): void
    {
        $this->publishes([
            __DIR__ . '/../config/admin-auth.php' => config_path('admin-auth.php'),
        ], 'config');
        $this->publishes([
            __DIR__ . '/../resources/admin/js' => resource_path('admin/js'),
            __DIR__ . '/../resources/admin/css' => resource_path('admin/css'),
            __DIR__ . '/../resources/admin/assets' => resource_path('admin/assets'),
            __DIR__ . '/../resources/admin/fonts' => resource_path('admin/fonts'),
        ], 'assets');
    }

    private function publishMiddleware(): void
    {
        $router = $this->app['router'];
        $router->aliasMiddleware('auth', AuthMiddleware::class);
    }

    private function registerComposers(): void
    {
        View::composer(
            ['maksb/admin::components.header'],
            HeaderComposer::class
        );
    }
}
