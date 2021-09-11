<?php

namespace RWP\Vendor\Exceptions\IO\Filesystem;

use RWP\Vendor\Exceptions\Tag\ForbiddenTag;
/**
 * Use this exception when your code tries to read the content of a directory but cannot do so due to filesystem
 * permissions.
 *
 * @author   Mathieu Dumoulin <thecrazycodr@gmail.com>
 * @license  MIT
 */
class DirectoryNotReadableException extends FilesystemException implements ForbiddenTag
{
    const MESSAGE = 'Cannot read from specified directory';
    const CODE = 0;
}
