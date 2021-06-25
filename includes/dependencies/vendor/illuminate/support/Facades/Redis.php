<?php

namespace RWP\Vendor\Illuminate\Support\Facades;

/**
 * @method static Connection connection(string $name = null)
 * @method static ConcurrencyLimiterBuilder funnel(string $name)
 * @method static DurationLimiterBuilder throttle(string $name)
 *
 * @see RedisManager
 * @see Factory
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
