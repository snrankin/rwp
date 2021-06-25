<?php

namespace RWP\Vendor\Illuminate\Contracts\Redis;

interface Factory
{
    /**
     * Get a Redis connection by name.
     *
     * @param  string|null  $name
     * @return Connection
     */
    public function connection($name = null);
}
