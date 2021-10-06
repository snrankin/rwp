<?php

namespace RWP\Vendor\Illuminate\Contracts\Filesystem;

interface Factory
{
    /**
     * Get a filesystem implementation.
     *
     * @param  string|null  $name
     * @returnFilesystem
     */
    public function disk($name = null);
}
