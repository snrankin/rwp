<?php

namespace RWP\Vendor\Illuminate\Contracts\Cache;

interface LockProvider
{
    /**
     * Get a lock instance.
     *
     * @param  string  $name
     * @param  int  $seconds
     * @param  string|null  $owner
     * @returnLock
     */
    public function lock($name, $seconds = 0, $owner = null);
    /**
     * Restore a lock instance using the owner identifier.
     *
     * @param  string  $name
     * @param  string  $owner
     * @returnLock
     */
    public function restoreLock($name, $owner);
}
