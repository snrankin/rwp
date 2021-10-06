<?php

namespace RWP\Vendor\Illuminate\Contracts\Queue;

interface Factory
{
    /**
     * Resolve a queue connection instance.
     *
     * @param  string|null  $name
     * @returnQueue
     */
    public function connection($name = null);
}
