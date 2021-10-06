<?php

namespace RWP\Vendor\Illuminate\Contracts\Broadcasting;

interface Factory
{
    /**
     * Get a broadcaster implementation by name.
     *
     * @param  string|null  $name
     * @returnBroadcaster
     */
    public function connection($name = null);
}
