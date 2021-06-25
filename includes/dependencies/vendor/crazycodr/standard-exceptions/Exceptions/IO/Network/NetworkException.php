<?php

namespace RWP\Vendor\Exceptions\IO\Network;

use RWP\Vendor\Exceptions\IO\IOException;
/**
 * This is a tag like class that is used to regroup all IO\Network exceptions under a single base class.
 *
 * @author   Mathieu Dumoulin <thecrazycodr@gmail.com>
 * @license  MIT
 */
abstract class NetworkException extends IOException implements NetworkExceptionInterface
{
}
