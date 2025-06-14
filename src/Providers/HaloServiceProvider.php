<?php

namespace DerrickSmith\HaloApi\Providers;

use DerrickSmith\HaloApi\HaloApi;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class HaloServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'halo');

        $this->app->singleton(HaloApi::class, function (Application $app) {
            return new HaloApi(config('halo'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/config.php' => config_path('halo.php'),
            ], 'halo-config');
        }
    }
}
