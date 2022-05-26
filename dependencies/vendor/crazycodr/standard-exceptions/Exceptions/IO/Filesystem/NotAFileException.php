<?php

namespace RWP\Vendor\Exceptions\IO\Filesystem;

use RWP\Vendor\Exceptions\Tag\InvalidDataTag;
/**
 * Use this exception when your code tries to do something on a file but the passed on item is not a file.
 *
 * @author   Mathieu Dumoulin <thecrazycodr@gmail.com>
 * @license  MIT
 */
class NotAFileException extends FilesystemException implements InvalidDataTag
{
    const MESSAGE = 'Specified path is not a file';
    const CODE = 0;
}
