<?php

if (! function_exists('settings')) {
    /**
     * Helper method for getting and setting settings
     *
     * @return mixed
     */
    function settings(...$args)
    {
        $settings = Illuminate\Support\Facades\App::make('settings');

        if (empty($args)) {
            return $settings;
        }

        return $settings(...$args);
    }
}
