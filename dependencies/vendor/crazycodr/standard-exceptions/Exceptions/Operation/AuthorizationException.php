<?php

namespace RWP\Vendor\Exceptions\Operation;

use RWP\Vendor\Exceptions\Tag\AbortedTag;
use RWP\Vendor\Exceptions\Tag\UnauthorizedTag;
/**
 * The user trying to execute an operation is not authorized to perform the operation expected. This results in an
 * incomplete operation but not necessarily in a full request authorization denial. This exception is the big brother
 * of the HTTP unauthorized exception.
 *
 * Note that you should catch this exception at your HTTP kernel level and convert it to HTTP Forbidden or
 * Unauthorized exceptions that match the HTTP response code 403 or 401. (Both are usable although there is a
 * never-ending debate on which to return)
 *
 * Use this exception internally as you don't want to throw a real ClientException around when you are not in an HTTP
 * context.
 *
 * @author   Mathieu Dumoulin aka CrazyCodr <thecrazycodr@gmail.com>
 * @license  MIT
 */
class AuthorizationException extends OperationException implements AbortedTag, UnauthorizedTag
{
    const MESSAGE = 'Requested operation could not be executed because of a lack of permission';
    const CODE = 0;
}
