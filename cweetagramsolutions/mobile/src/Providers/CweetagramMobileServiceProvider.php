<?php

namespace Cweetagramsolutions\Mobile\Providers;

use Cweetagramsolutions\Mobile\Commands\PushInfobipMessages;
use Cweetagramsolutions\Mobile\Commands\PushMobisysRecharges;
use \Illuminate\Support\ServiceProvider;

class CweetagramMobileServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');
        if ($this->app->runningInConsole()) {
            $this->commands([
                PushInfobipMessages::class,
                PushMobisysRecharges::class,
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../Config/cweetagram_mobile.php', 'cweetagramsolutions');
    }
}
