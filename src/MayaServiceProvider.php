<?php

namespace Iss\LaravelMayaSdk;

use Illuminate\Support\ServiceProvider;

class MayaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('maya', function(){
            return new Maya;
        });

        $this->mergeConfigFrom(
            __DIR__.'/../config/maya.php', 'maya'
        );

    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/maya.php' => config_path('maya.php'),
        ], 'maya');
    }
}
