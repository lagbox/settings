<?php

namespace lagbox\Settings;

use Illuminate\Support\ServiceProvider;
use lagbox\Settings\Events\SettingsSaved;
use lagbox\Settings\Listeners\SettingsListener;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap anything needed.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes();

        // add the middleware
        $this->app['router']->middleware('settings', SettingsMiddleware::class);

        // add the event listener
        $this->app['events']->listen(SettingsSaved::class, SettingsListener::class);
    }

    /**
     * Register any bindings with the container.
     *
     * @return void
     */
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

    /**
     * Assets to publish.
     *
     * @return void
     */
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