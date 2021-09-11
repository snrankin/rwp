<?php

namespace RWP\Vendor\Carbon\Laravel;

use RWP\Vendor\Carbon\Carbon;
use RWP\Vendor\Carbon\CarbonImmutable;
use RWP\Vendor\Carbon\CarbonInterval;
use RWP\Vendor\Carbon\CarbonPeriod;
use RWP\Vendor\Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use RWP\Vendor\Illuminate\Events\Dispatcher;
use RWP\Vendor\Illuminate\Events\EventDispatcher;
use RWP\Vendor\Illuminate\Support\Carbon as IlluminateCarbon;
use RWP\Vendor\Illuminate\Support\Facades\Date;
use Throwable;
class ServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->updateLocale();
        if (!$this->app->bound('events')) {
            return;
        }
        $service = $this;
        $events = $this->app['events'];
        if ($this->isEventDispatcher($events)) {
            $events->listen(\class_exists( __NAMESPACE__  .  '\\LocaleUpdated') ? 'Illuminate\\Foundation\\Events\\LocaleUpdated' : 'locale.changed', function () use($service) {
                $service->updateLocale();
            });
        }
    }
    public function updateLocale()
    {
        $app = $this->app && \method_exists($this->app, 'getLocale') ? $this->app : app('translator');
        $locale = $app->getLocale();
        Carbon::setLocale($locale);
        CarbonImmutable::setLocale($locale);
        CarbonPeriod::setLocale($locale);
        CarbonInterval::setLocale($locale);
        if (\class_exists(Carbon::class)) {
            Carbon::setLocale($locale);
        }
        if (\class_exists(Date::class)) {
            try {
                $root = Date::getFacadeRoot();
                $root->setLocale($locale);
            } catch (\Throwable $e) {
                // Non Carbon class in use in Date facade
            }
        }
    }
    public function register()
    {
        // Needed for Laravel < 5.3 compatibility
    }
    protected function isEventDispatcher($instance)
    {
        return $instance instanceof EventDispatcher || $instance instanceof Dispatcher || $instance instanceof Dispatcher;
    }
}
