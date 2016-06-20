<?php

namespace lagbox\settings\Listeners;

use lagbox\settings\Setting;
use lagbox\settings\Events\SettingsSaved;
use Illuminate\Contracts\Cache\Repository as Cache;

class SettingsListener
{
    protected $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Handle the post creation events.
     *
     * @param $event
     */
    public function handle(SettingsSaved $event)
    {
        $this->cache->forget('settings');
    }
}
