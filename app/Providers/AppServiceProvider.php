<?php

namespace App\Providers;

use Illuminate\Foundation\AliasLoader as FoundationAliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\AliasLoader;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }
    

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
