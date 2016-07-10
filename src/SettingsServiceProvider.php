<?php

namespace lagbox\settings;

use Illuminate\Support\ServiceProvider;
use lagbox\settings\Events\SettingsSaved;
use lagbox\settings\Listeners\SettingsListener;

class SettingsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes();

        // add the middleware
        $this->app['router']->middleware('settings', SettingsMiddleware::class);

        // add the event listener
        $this->app['events']->listen(SettingsSaved::class, SettingsListener::class);
    }

    public function register()
    {
        $this->app->singleton('settings', function ($app) {
            return new Settings(
                $app['cache.store'],
                $app['config'],
                $app['events'],
                new Setting
            );
        });

        $this->app->alias('settings', Settings::class);
    }

    protected function publishes()
    {
        $this->publishes([
            __DIR__.'/../config/settings.php' => config_path('settings.php')
        ], 'config');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');
    }
}