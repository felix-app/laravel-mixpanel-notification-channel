<?php

namespace NotificationChannels\Mixpanel;

use Illuminate\Support\ServiceProvider;

class MixpanelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
        $this->app->when(MixpanelChannel::class)
            ->needs(Mandrill::class)
            ->give(function () {
                $apiKey = config('services.mandrill.secret');

                return new Mandrill($apiKey);
            });
        */
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
