<?php

namespace RWP\Vendor\Exceptions\IO\Filesystem;

use RWP\Vendor\Exceptions\Tag\NotFoundTag;
/**
 * Use this exception when your code tries to open a file but cannot find it.
 *
 * @author   Mathieu Dumoulin <thecrazycodr@gmail.com>
 * @license  MIT
 */
class FileNotFoundException extends FilesystemException implements NotFoundTag
{
    const MESSAGE = 'Cannot find specified file';
    const CODE = 0;
}
