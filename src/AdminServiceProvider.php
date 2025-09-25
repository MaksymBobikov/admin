<?php

namespace Maksb\Admin;

use Illuminate\Support\ServiceProvider;
use Maksb\Admin\Http\Middleware\AuthMiddleware;

class AdminServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ]);
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'maksb/admin');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $router = $this->app['router'];
        $router->aliasMiddleware('auth', AuthMiddleware::class);
    }

    public function register(): void
    {
    }
}
