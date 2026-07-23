<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;          // ← tambahan ini

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
    // Cara BENAR dan AMAN untuk Laravel 11/12
    if (!app()->runningInConsole() && app()->environment('production')) {
        \Illuminate\Support\Facades\URL::forceScheme('https');
    }

    // Atau cara paling aman (recommended Laravel resmi sejak L11):
    // \Illuminate\Support\Facades\URL::forceScheme('https');
}
}
