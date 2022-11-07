<?php

namespace Cweetagramsolutions\Mobile\Providers;

use \Illuminate\Support\ServiceProvider;

class CweetagramMobileServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/cweetagram_mobile.php', 'cweetagramsolutions');
    }
}
