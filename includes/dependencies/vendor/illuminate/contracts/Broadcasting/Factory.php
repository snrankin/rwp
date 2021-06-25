<?php

namespace RWP\Vendor\Illuminate\Contracts\Broadcasting;

interface Factory
{
    /**
     * Get a broadcaster implementation by name.
     *
     * @param  string|null  $name
     * @return Broadcaster
     */
    public function connection($name = null);
}
