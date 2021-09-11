<?php

namespace RWP\Vendor\Exceptions\IO\Filesystem;

use RWP\Vendor\Exceptions\Tag\InvalidDataTag;
/**
 * Use this exception when your code tries to do something on a directory but the passed on item is not a directory.
 *
 * @author   Mathieu Dumoulin <thecrazycodr@gmail.com>
 * @license  MIT
 */
class NotADirectoryException extends FilesystemException implements InvalidDataTag
{
    const MESSAGE = 'Specified path is not a directory';
    const CODE = 0;
}
