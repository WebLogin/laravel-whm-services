<?php
namespace WebLogin\LaravelWhmServices;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;


class ServiceProvider extends BaseServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/whm-services.php', 'whm-services');
    }


    public function boot()
    {
        $this->commands(Commands\Restart::class);
    }

}
