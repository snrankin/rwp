<?php

namespace RWP\Vendor\Illuminate\Support\Facades;

use RWP\Vendor\Illuminate\Contracts\Broadcasting\Factory as BroadcastingFactoryContract;
/**
 * @method static Broadcaster channel(string $channel, callable|string  $callback, array $options = [])
 * @method static mixed auth(\Illuminate\Http\Request $request)
 * @method static Broadcaster connection($name = null);
 * @method static void routes(array $attributes = null)
 * @method static BroadcastManager socket($request = null)
 *
 * @see Factory
 */
class Broadcast extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}
