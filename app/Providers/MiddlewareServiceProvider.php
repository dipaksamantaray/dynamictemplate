<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Laravel\Passport\Http\Middleware\CheckScopes;
use Laravel\Passport\Http\Middleware\CheckForAnyScope;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // You can leave this empty as we are only registering middleware in the boot method
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /** @var Router $router */
        $router = $this->app->make('router');

        // Register middleware aliases for scopes
        $router->aliasMiddleware('scope', CheckScopes::class);
        $router->aliasMiddleware('scopes', CheckForAnyScope::class);
    }
}
