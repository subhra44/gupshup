<?php

namespace Subhra\Gupshup\Providers;

use Illuminate\Support\ServiceProvider;
use Subhra\Gupshup\Gupshup;

class GupshupServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/gupshup.php' => config_path('gupshup.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/gupshup.php',
            'gupshup'
        );

        $this->app->singleton('gupshup', function () {
            return new Gupshup();
        });
    }
}
