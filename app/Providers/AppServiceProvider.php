<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(ConfigServiceProvider::class);

        $this->app->withEloquent();
        $this->app->withFacades();

        $this->app->register(LoggerServiceProvider::class);
    }
}
