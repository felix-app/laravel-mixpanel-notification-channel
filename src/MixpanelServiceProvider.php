<?php

namespace NotificationChannels\Mixpanel;

use Illuminate\Support\ServiceProvider;

use Mixpanel;

class MixpanelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {        
        $this->app->when(MixpanelChannel::class)
            ->needs(Mixpanel::class)
            ->give(function () {
                $apiKey = config('services.mixpanel.secret');                
                return Mixpanel::getInstance($apiKey);
            });        
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $source = realpath(__DIR__.'/../config/services.php');
        
        $this->mergeConfigFrom($source, 'services.mixpanel');
    }
}
