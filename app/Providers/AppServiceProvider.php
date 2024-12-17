<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Passport::loadKeysFrom(base_path('app/secrets/oauth'));
        // Passport::tokensCan([
        //     'view-profile' => 'View user profile',
        //     'edit-profile' => 'Edit user profile',
        //     'admin' => 'Admin privileges',
        // ]);
    
    }
}
