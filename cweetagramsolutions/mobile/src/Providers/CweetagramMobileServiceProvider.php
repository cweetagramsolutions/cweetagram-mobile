<?php

namespace Cweetagramsolutions\Mobile\Providers;

use \Illuminate\Support\ServiceProvider;

class CweetagramMobileServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../Config/cweetagram_mobile.php', 'cweetagramsolutions');
    }
}
