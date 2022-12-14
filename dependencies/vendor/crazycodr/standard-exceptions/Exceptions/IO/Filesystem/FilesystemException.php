<?php

namespace RWP\Vendor\Exceptions\IO\Filesystem;

use RWP\Vendor\Exceptions\IO\IOException;
/**
 * This is a tag like class that is used to regroup all IO\Filesystem exceptions under a single base class.
 *
 * @author   Mathieu Dumoulin <thecrazycodr@gmail.com>
 * @license  MIT
 */
abstract class FilesystemException extends IOException implements FilesystemExceptionInterface
{
}
