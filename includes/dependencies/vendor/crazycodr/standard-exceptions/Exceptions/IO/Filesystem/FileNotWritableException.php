<?php

namespace RWP\Vendor\Exceptions\IO\Filesystem;

use RWP\Vendor\Exceptions\Tag\ForbiddenTag;
/**
 * Use this exception when your code tries to write some content to a file but cannot do so due to filesystem
 * permissions.
 *
 * @author   Mathieu Dumoulin <thecrazycodr@gmail.com>
 * @license  MIT
 */
class FileNotWritableException extends FilesystemException implements ForbiddenTag
{
    const MESSAGE = 'Cannot write to specified file';
    const CODE = 0;
}
