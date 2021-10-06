<?php

namespace RWP\Vendor\Illuminate\Support\Facades;

/**
 * @method staticConnection connection(string $name = null)
 * @method static \Illuminate\Redis\Limiters\ConcurrencyLimiterBuilder funnel(string $name)
 * @method static \Illuminate\Redis\Limiters\DurationLimiterBuilder throttle(string $name)
 *
 * @seeRedisManager
 * @see \Illuminate\Contracts\Redis\Factory
 */
class Redis extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'redis';
    }
}
