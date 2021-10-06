<?php

namespace RWP\Vendor\Illuminate\Support\Facades;

use RWP\Vendor\Illuminate\Contracts\Broadcasting\Factory as BroadcastingFactoryContract;
/**
 * @method staticBroadcaster channel(string $channel, callable|string  $callback, array $options = [])
 * @method static mixed auth(\Illuminate\Http\Request $request)
 * @method staticBroadcaster connection($name = null);
 * @method static void routes(array $attributes = null)
 * @method staticBroadcastManager socket($request = null)
 *
 * @seeFactory
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
