<?php

namespace lagbox\settings;

use Closure;

class SettingsMiddleware
{
    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // If there are any dirty settings, save them.
        if ($this->settings->isDirty()) {
            $this->settings->wash();
        }

        return $response;
    }
}
