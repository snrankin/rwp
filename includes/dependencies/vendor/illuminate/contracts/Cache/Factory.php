<?php

namespace RWP\Vendor\Illuminate\Contracts\Cache;

interface Factory
{
    /**
     * Get a cache store instance by name.
     *
     * @param  string|null  $name
     * @returnRepository
     */
    public function store($name = null);
}
